<?php
/**
 * SixOrbit UI Demo - Form Enhancements
 * Input masking, password strength, character counter, clear button, prefix/suffix
 */
$pageTitle = 'Form Enhancements';
$pageDescription = 'Input masking, password strength meter, character counter, clear button, and prefix/suffix improvements';

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
            <h1 class="so-page-title">Form Enhancements</h1>
            <p class="so-page-subtitle">Input masking, password strength meter, character counter, clear button, and prefix/suffix improvements</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

        <!-- Input Masking Section -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input Masking</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Format user input automatically for phone numbers, credit cards, dates, and more.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Phone Number</label>
                            <input type="text"
                                   class="so-form-control"
                                   data-so-input-mask
                                   data-so-mask="phone"
                                   placeholder="(___) ___-____">
                            <span class="so-mask-hint">Format: (###) ###-####</span>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Credit Card</label>
                            <input type="text"
                                   class="so-form-control"
                                   data-so-input-mask
                                   data-so-mask="card"
                                   placeholder="____ ____ ____ ____">
                            <span class="so-mask-hint">Format: #### #### #### ####</span>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Date (MM/DD/YYYY)</label>
                            <input type="text"
                                   class="so-form-control"
                                   data-so-input-mask
                                   data-so-mask="date"
                                   placeholder="__/__/____">
                            <span class="so-mask-hint">Format: MM/DD/YYYY</span>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Time (HH:MM)</label>
                            <input type="text"
                                   class="so-form-control"
                                   data-so-input-mask
                                   data-so-mask="time"
                                   placeholder="__:__">
                            <span class="so-mask-hint">Format: HH:MM</span>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">SSN</label>
                            <input type="text"
                                   class="so-form-control"
                                   data-so-input-mask
                                   data-so-mask="ssn"
                                   placeholder="___-__-____">
                            <span class="so-mask-hint">Format: ###-##-####</span>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">ZIP Code</label>
                            <input type="text"
                                   class="so-form-control"
                                   data-so-input-mask
                                   data-so-mask="zip"
                                   placeholder="_____">
                            <span class="so-mask-hint">Format: #####</span>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<!-- Phone Number Mask -->
<input type="text"
       class="so-form-control"
       data-so-input-mask
       data-so-mask="phone"
       placeholder="(___) ___-____">

<!-- Credit Card Mask -->
<input type="text"
       class="so-form-control"
       data-so-input-mask
       data-so-mask="card">

<!-- Date Mask -->
<input type="text"
       class="so-form-control"
       data-so-input-mask
       data-so-mask="date">

<!-- Available masks: phone, card, date, time, ssn, zip, zipExt, ein -->', 'html') ?>
            </div>
        </div>

        <!-- Currency & Percentage Masking -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Currency & Percentage Masking</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Numeric input formatting with thousands separators and decimal places.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Currency</label>
                            <div class="so-input-group">
                                <span class="so-input-addon">$</span>
                                <input type="text"
                                       class="so-form-control"
                                       data-so-input-mask
                                       data-so-mask="currency"
                                       placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Percentage</label>
                            <div class="so-input-group">
                                <input type="text"
                                       class="so-form-control"
                                       data-so-input-mask
                                       data-so-mask="percentage"
                                       placeholder="0">
                                <span class="so-input-addon">%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<!-- Currency Input -->
<div class="so-input-group">
    <span class="so-input-addon">$</span>
    <input type="text"
           class="so-form-control"
           data-so-input-mask
           data-so-mask="currency">
</div>

<!-- Percentage Input -->
<div class="so-input-group">
    <input type="text"
           class="so-form-control"
           data-so-input-mask
           data-so-mask="percentage">
    <span class="so-input-addon">%</span>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Password Strength Meter Section -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Password Strength Meter</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Visual feedback for password strength with customizable requirements.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Password (with bar)</label>
                            <div class="so-input-wrapper">
                                <input type="password"
                                       class="so-form-control"
                                       data-so-password-strength
                                       data-so-show-bar="true"
                                       placeholder="Enter a strong password">
                                <button type="button" class="so-input-action" onclick="togglePassword(this)">
                                    <span class="material-icons">visibility</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Password (with requirements)</label>
                            <div class="so-input-wrapper">
                                <input type="password"
                                       class="so-form-control"
                                       data-so-password-strength
                                       data-so-show-bar="true"
                                       data-so-show-requirements="true"
                                       placeholder="Enter a strong password">
                                <button type="button" class="so-input-action" onclick="togglePassword(this)">
                                    <span class="material-icons">visibility</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<!-- Password with strength bar -->
<input type="password"
       class="so-form-control"
       data-so-password-strength
       data-so-show-bar="true"
       placeholder="Enter a strong password">

<!-- Password with requirements list -->
<input type="password"
       class="so-form-control"
       data-so-password-strength
       data-so-show-bar="true"
       data-so-show-requirements="true"
       placeholder="Enter a strong password">

<!-- Options:
     data-so-min-length="8"
     data-so-require-uppercase="true"
     data-so-require-lowercase="true"
     data-so-require-numbers="true"
     data-so-require-special="true"
     data-so-show-inline="true"
-->', 'html') ?>
            </div>
        </div>

        <!-- Character Counter Section -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Character Counter</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Track character, word, or line count with optional limits and warnings.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Simple Counter (no limit)</label>
                            <input type="text"
                                   class="so-form-control"
                                   data-so-char-counter
                                   placeholder="Type something...">
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">With Max Length (50 chars)</label>
                            <input type="text"
                                   class="so-form-control"
                                   data-so-char-counter
                                   data-so-max-length="50"
                                   placeholder="Max 50 characters">
                        </div>
                    </div>
                    <div class="so-col-12">
                        <div class="so-form-group">
                            <label class="so-form-label">Textarea with Progress Bar (200 chars)</label>
                            <textarea class="so-form-control"
                                      rows="3"
                                      data-so-char-counter
                                      data-so-max-length="200"
                                      data-so-show-bar="true"
                                      placeholder="Write your message here..."></textarea>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Word Counter</label>
                            <textarea class="so-form-control"
                                      rows="3"
                                      data-so-char-counter
                                      data-so-mode="words"
                                      data-so-max-length="50"
                                      placeholder="Write up to 50 words..."></textarea>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Inline Counter (inside textarea)</label>
                            <textarea class="so-form-control"
                                      rows="3"
                                      data-so-char-counter
                                      data-so-max-length="150"
                                      data-so-show-inline="true"
                                      placeholder="Counter appears inside the textarea..."></textarea>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<!-- Simple character counter -->
<input type="text"
       class="so-form-control"
       data-so-char-counter>

<!-- With max length -->
<input type="text"
       class="so-form-control"
       data-so-char-counter
       data-so-max-length="50">

<!-- With progress bar -->
<textarea class="so-form-control"
          data-so-char-counter
          data-so-max-length="200"
          data-so-show-bar="true"></textarea>

<!-- Word counter -->
<textarea class="so-form-control"
          data-so-char-counter
          data-so-mode="words"
          data-so-max-length="50"></textarea>

<!-- Inline counter -->
<textarea class="so-form-control"
          data-so-char-counter
          data-so-show-inline="true"></textarea>', 'html') ?>
            </div>
        </div>

        <!-- Clear Button Section -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Clear Button (X to Clear)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add a clear button to inputs that appears when there's content. Press Escape to clear.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Basic Clear Button</label>
                            <input type="text"
                                   class="so-form-control"
                                   data-so-input-clear
                                   placeholder="Type and see the X button">
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">With Icon (Search)</label>
                            <div class="so-input-wrapper">
                                <span class="so-input-icon">
                                    <span class="material-icons">search</span>
                                </span>
                                <input type="text"
                                       class="so-form-control"
                                       data-so-input-clear
                                       placeholder="Search...">
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Pre-filled Value</label>
                            <input type="text"
                                   class="so-form-control"
                                   data-so-input-clear
                                   value="Click X to clear this">
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">With Other Action</label>
                            <div class="so-input-wrapper">
                                <input type="password"
                                       class="so-form-control"
                                       data-so-input-clear
                                       placeholder="Password with clear + toggle">
                                <button type="button" class="so-input-action" onclick="togglePassword(this)">
                                    <span class="material-icons">visibility</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<!-- Basic clear button -->
<input type="text"
       class="so-form-control"
       data-so-input-clear
       placeholder="Type and see the X button">

<!-- With search icon -->
<div class="so-input-wrapper">
    <span class="so-input-icon">
        <span class="material-icons">search</span>
    </span>
    <input type="text"
           class="so-form-control"
           data-so-input-clear
           placeholder="Search...">
</div>

<!-- Pro tip: Press Escape to clear when focused -->', 'html') ?>
            </div>
        </div>

        <!-- Prefix/Suffix Improvements Section -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Prefix/Suffix Improvements</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Enhanced input addons with colors, sizes, and interactive variants.</p>

                <h6 class="so-text-muted so-mb-3">Colored Addons</h6>
                <div class="so-row so-g-4 so-mb-5">
                    <div class="so-col-md-4">
                        <div class="so-input-group">
                            <span class="so-input-addon so-input-addon-primary">
                                <span class="material-icons">mail</span>
                            </span>
                            <input type="email" class="so-form-control" placeholder="Primary addon">
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-input-group">
                            <span class="so-input-addon so-input-addon-success">
                                <span class="material-icons">check_circle</span>
                            </span>
                            <input type="text" class="so-form-control" placeholder="Success addon">
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-input-group">
                            <span class="so-input-addon so-input-addon-danger">
                                <span class="material-icons">error</span>
                            </span>
                            <input type="text" class="so-form-control" placeholder="Danger addon">
                        </div>
                    </div>
                </div>

                <h6 class="so-text-muted so-mb-3">Addon Sizes</h6>
                <div class="so-row so-g-4 so-mb-5">
                    <div class="so-col-md-4">
                        <div class="so-input-group">
                            <span class="so-input-addon so-input-addon-compact">@</span>
                            <input type="text" class="so-form-control" placeholder="Compact addon">
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-input-group">
                            <span class="so-input-addon">@</span>
                            <input type="text" class="so-form-control" placeholder="Default addon">
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-input-group">
                            <span class="so-input-addon so-input-addon-wide">https://</span>
                            <input type="text" class="so-form-control" placeholder="Wide addon">
                        </div>
                    </div>
                </div>

                <h6 class="so-text-muted so-mb-3">Clickable & Dropdown Addons</h6>
                <div class="so-row so-g-4 so-mb-5">
                    <div class="so-col-md-6">
                        <div class="so-input-group">
                            <span class="so-input-addon so-input-addon-clickable" onclick="alert('Addon clicked!')">
                                <span class="material-icons">content_copy</span>
                            </span>
                            <input type="text" class="so-form-control" placeholder="Clickable addon">
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-input-group">
                            <span class="so-input-addon so-input-addon-dropdown">
                                USD
                            </span>
                            <input type="text" class="so-form-control" placeholder="Dropdown addon">
                        </div>
                    </div>
                </div>

                <h6 class="so-text-muted so-mb-3">Input Presets</h6>
                <div class="so-row so-g-4">
                    <div class="so-col-md-4">
                        <label class="so-form-label">Currency Input</label>
                        <div class="so-input-prefix so-input-currency" style="--so-prefix-width: 30px;">
                            <span class="so-prefix-text">$</span>
                            <input type="text" class="so-form-control" placeholder="0.00">
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <label class="so-form-label">Percentage Input</label>
                        <div class="so-input-suffix so-input-percentage" style="--so-suffix-width: 40px;">
                            <input type="text" class="so-form-control" placeholder="0">
                            <span class="so-suffix-text">%</span>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <label class="so-form-label">URL Input</label>
                        <div class="so-input-prefix so-input-url" style="--so-prefix-width: 80px;">
                            <span class="so-prefix-text">https://</span>
                            <input type="text" class="so-form-control" placeholder="example.com">
                        </div>
                    </div>
                </div>

                <?= so_code_block('<!-- Colored addons -->
<div class="so-input-group">
    <span class="so-input-addon so-input-addon-primary">
        <span class="material-icons">mail</span>
    </span>
    <input type="email" class="so-form-control">
</div>

<!-- Available colors: primary, success, danger, warning, info -->

<!-- Compact/Wide addons -->
<span class="so-input-addon so-input-addon-compact">@</span>
<span class="so-input-addon so-input-addon-wide">https://</span>

<!-- Clickable addon -->
<span class="so-input-addon so-input-addon-clickable" onclick="...">
    <span class="material-icons">content_copy</span>
</span>

<!-- Prefix/Suffix text (inline) -->
<div class="so-input-prefix so-input-currency" style="--so-prefix-width: 30px;">
    <span class="so-prefix-text">$</span>
    <input type="text" class="so-form-control">
</div>', 'html') ?>
            </div>
        </div>

        <!-- Input Loading State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input Loading State</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Show a spinner inside the input during async operations.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Loading State</label>
                            <div class="so-input-loading">
                                <input type="text" class="so-form-control" value="Validating..." readonly>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <div class="so-form-group">
                            <label class="so-form-label">Toggle Loading</label>
                            <div id="toggleLoadingWrapper">
                                <input type="text" class="so-form-control" placeholder="Type something" id="toggleLoadingInput">
                            </div>
                            <button class="so-btn so-btn-sm so-btn-outline so-mt-2" onclick="toggleLoading()">Toggle Loading</button>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<!-- Input with loading spinner -->
<div class="so-input-loading">
    <input type="text" class="so-form-control" value="Validating...">
</div>

<!-- Toggle loading via JavaScript -->
wrapper.classList.toggle(\'so-input-loading\');', 'html') ?>
            </div>
        </div>

        <!-- Validation Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation Icons</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Show validation status icons inside the input.</p>

                <div class="so-row so-g-4">
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Valid Input</label>
                            <div class="so-input-validated so-is-valid">
                                <input type="text" class="so-form-control so-form-control-success" value="john@example.com">
                                <span class="so-validation-icon">
                                    <span class="material-icons">check_circle</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Invalid Input</label>
                            <div class="so-input-validated so-is-invalid">
                                <input type="text" class="so-form-control so-form-control-danger" value="invalid-email">
                                <span class="so-validation-icon">
                                    <span class="material-icons">error</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Warning Input</label>
                            <div class="so-input-validated so-is-warning">
                                <input type="text" class="so-form-control so-form-control-warning" value="weak-password">
                                <span class="so-validation-icon">
                                    <span class="material-icons">warning</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<!-- Valid input with icon -->
<div class="so-input-validated so-is-valid">
    <input type="text" class="so-form-control so-form-control-success" value="valid value">
    <span class="so-validation-icon">
        <span class="material-icons">check_circle</span>
    </span>
</div>

<!-- Invalid input with icon -->
<div class="so-input-validated so-is-invalid">
    <input type="text" class="so-form-control so-form-control-danger" value="invalid">
    <span class="so-validation-icon">
        <span class="material-icons">error</span>
    </span>
</div>', 'html') ?>
            </div>
        </div>

        <!-- JavaScript API -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript API</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Programmatic control and event handling for all form enhancers.</p>

                <?= so_code_block('// Input Mask
const maskInput = document.querySelector(\'[data-so-input-mask]\');
const mask = new SOInputMask(maskInput, {
    mask: \'phone\',
    showMask: true
});

mask.getValue();      // Formatted value
mask.getRawValue();   // Unformatted value
mask.setValue(\'5551234567\');
mask.clear();

// Password Strength
const pwInput = document.querySelector(\'[data-so-password-strength]\');
const strength = new SOPasswordStrength(pwInput, {
    minLength: 8,
    requireUppercase: true,
    requireNumbers: true,
    showBar: true,
    showRequirements: true
});

strength.getScore();        // 0-5
strength.getStrength();     // \'weak\', \'fair\', \'good\', \'strong\'
strength.getRequirements(); // { length: true, uppercase: false, ... }
strength.isValid();         // true/false

// Events
pwInput.addEventListener(\'so:password-strength:change\', (e) => {
    console.log(e.detail.strength, e.detail.score);
});

// Character Counter
const textarea = document.querySelector(\'[data-so-char-counter]\');
const counter = new SOCharCounter(textarea, {
    maxLength: 200,
    mode: \'characters\', // or \'words\', \'lines\'
    showBar: true,
    warningThreshold: 80
});

counter.getCount();
counter.getPercentage();
counter.getRemaining();
counter.setMaxLength(300);

// Events
textarea.addEventListener(\'so:char-counter:warning\', (e) => {
    console.log(\'Approaching limit!\', e.detail.percentage);
});

// Input Clear
const input = document.querySelector(\'[data-so-input-clear]\');
const clearBtn = new SOInputClear(input, {
    focusAfterClear: true,
    onClear: (oldValue) => console.log(\'Cleared:\', oldValue)
});

clearBtn.clear();
clearBtn.showButton();
clearBtn.hideButton();', 'javascript') ?>
            </div>
        </div>

    </div>
</main>

<script>
// Toggle password visibility
function togglePassword(button) {
    const input = button.closest('.so-input-wrapper, .so-password-wrapper').querySelector('input');
    const icon = button.querySelector('.material-icons');

    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}

// Toggle loading state demo
function toggleLoading() {
    const wrapper = document.getElementById('toggleLoadingWrapper');
    wrapper.classList.toggle('so-input-loading');
}

function copyCode(button) {
    const codeBlock = button.closest('.so-code-block');
    const code = codeBlock.querySelector('.so-code-content code').textContent;
    navigator.clipboard.writeText(code).then(() => {
        button.innerHTML = '<span class="material-icons">check</span>';
        setTimeout(() => {
            button.innerHTML = '<span class="material-icons">content_copy</span>';
        }, 2000);
    });
}
</script>

<?php require_once '../includes/footer.php'; ?>
