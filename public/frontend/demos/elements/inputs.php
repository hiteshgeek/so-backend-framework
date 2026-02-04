<?php
/**
 * SixOrbit UI Demo - Form Inputs
 */
$pageTitle = 'Form Inputs';
$pageDescription = 'Text inputs, textareas, and form controls';

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
            <h1 class="so-page-title">Form Inputs</h1>
            <p class="so-page-subtitle">Text inputs, textareas, and form controls</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<!-- Section 1: Basic Inputs -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Basic Inputs</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label" for="input-default">Default Input</label>
                                <input type="text" id="input-default" class="so-form-control" placeholder="Enter text...">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-with-value">With Value</label>
                                <input type="text" id="input-with-value" class="so-form-control" value="John Doe">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label so-required" for="input-required">Required Field</label>
                                <input type="text" id="input-required" class="so-form-control" placeholder="This field is required" required>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-password">Password Input</label>
                                <input type="password" id="input-password" class="so-form-control" placeholder="Enter password">
                            </div>
                        </div>
                        <?= so_code_block('<div class="so-form-group">
    <label class="so-form-label" for="my-input">Default Input</label>
    <input type="text" id="my-input" class="so-form-control" placeholder="Enter text...">
</div>

<div class="so-form-group">
    <label class="so-form-label so-required" for="required-input">Required Field</label>
    <input type="text" id="required-input" class="so-form-control" placeholder="This field is required" required>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Section 2: Input Sizes -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Input Sizes</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label" for="input-small">Small Input</label>
                                <input type="text" id="input-small" class="so-form-control so-form-control-sm" placeholder="Small input">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-default-size">Default Input</label>
                                <input type="text" id="input-default-size" class="so-form-control" placeholder="Default input">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-large">Large Input</label>
                                <input type="text" id="input-large" class="so-form-control so-form-control-lg" placeholder="Large input">
                            </div>
                        </div>
                        <?= so_code_block('<label class="so-form-label" for="small">Small</label>
<input type="text" id="small" class="so-form-control so-form-control-sm" placeholder="Small">

<label class="so-form-label" for="default">Default</label>
<input type="text" id="default" class="so-form-control" placeholder="Default">

<label class="so-form-label" for="large">Large</label>
<input type="text" id="large" class="so-form-control so-form-control-lg" placeholder="Large">', 'html') ?>
                    </div>
                </div>

                <!-- Section 3: Input with Icons -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Input with Icons</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label" for="input-search">Left Icon</label>
                                <div class="so-input-wrapper">
                                    <span class="so-input-icon"><span class="material-icons">search</span></span>
                                    <input type="text" id="input-search" class="so-form-control" placeholder="Search...">
                                </div>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-email-icon">Right Icon</label>
                                <div class="so-input-wrapper icon-right">
                                    <input type="text" id="input-email-icon" class="so-form-control" placeholder="Email address">
                                    <span class="so-input-icon"><span class="material-icons">email</span></span>
                                </div>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-clearable">Clearable Input</label>
                                <div class="so-input-wrapper icon-right">
                                    <input type="text" id="input-clearable" class="so-form-control" placeholder="Type to clear..." value="Clear me">
                                    <button type="button" class="so-input-clear" aria-label="Clear input">
                                        <span class="material-icons">close</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Dual Icons Section -->
                        <h5 class="so-mt-5 so-mb-3">Dual Icons (Left Icon + Right Action)</h5>
                        <p class="so-text-secondary so-mb-4">Use <code>so-input-icon</code> for left icon and <code>so-input-action</code> for clickable right actions like password toggles.</p>
                        <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label" for="input-password-demo">Password with Toggle</label>
                                <div class="so-input-wrapper">
                                    <span class="so-input-icon"><span class="material-icons">lock</span></span>
                                    <input type="password" id="input-password-demo" class="so-form-control" placeholder="Enter password">
                                    <button type="button" class="so-input-action" onclick="togglePasswordVisibility(this)" aria-label="Toggle password">
                                        <span class="material-icons">visibility</span>
                                    </button>
                                </div>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-search-clear">Search with Clear</label>
                                <div class="so-input-wrapper">
                                    <span class="so-input-icon"><span class="material-icons">search</span></span>
                                    <input type="text" id="input-search-clear" class="so-form-control" placeholder="Search..." value="Example query">
                                    <button type="button" class="so-input-action" onclick="this.previousElementSibling.value=''; this.previousElementSibling.focus();" aria-label="Clear search">
                                        <span class="material-icons">close</span>
                                    </button>
                                </div>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-url-copy">URL with Copy</label>
                                <div class="so-input-wrapper">
                                    <span class="so-input-icon"><span class="material-icons">link</span></span>
                                    <input type="text" id="input-url-copy" class="so-form-control" value="https://sixorbit.com" readonly>
                                    <button type="button" class="so-input-action" onclick="navigator.clipboard.writeText(this.previousElementSibling.value)" aria-label="Copy URL">
                                        <span class="material-icons">content_copy</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <?= so_code_block('<!-- Left Icon -->
<div class="so-input-wrapper">
    <span class="so-input-icon"><span class="material-icons">search</span></span>
    <input type="text" class="so-form-control" placeholder="Search...">
</div>

<!-- Right Icon (static) -->
<div class="so-input-wrapper icon-right">
    <input type="text" class="so-form-control" placeholder="Email">
    <span class="so-input-icon"><span class="material-icons">email</span></span>
</div>

<!-- Dual Icons: Left Icon + Right Action (password toggle) -->
<div class="so-input-wrapper">
    <span class="so-input-icon"><span class="material-icons">lock</span></span>
    <input type="password" class="so-form-control" placeholder="Enter password">
    <button type="button" class="so-input-action" aria-label="Toggle password">
        <span class="material-icons">visibility</span>
    </button>
</div>

<!-- Dual Icons: Search with Clear -->
<div class="so-input-wrapper">
    <span class="so-input-icon"><span class="material-icons">search</span></span>
    <input type="text" class="so-form-control" placeholder="Search...">
    <button type="button" class="so-input-action" aria-label="Clear">
        <span class="material-icons">close</span>
    </button>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Section 4: Contextual Inputs -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Contextual Inputs</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label" for="input-ctx-primary">Primary</label>
                                <input type="text" id="input-ctx-primary" class="so-form-control so-form-control-primary" placeholder="Primary input">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-ctx-secondary">Secondary</label>
                                <input type="text" id="input-ctx-secondary" class="so-form-control so-form-control-secondary" placeholder="Secondary input">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-ctx-success">Success</label>
                                <input type="text" id="input-ctx-success" class="so-form-control so-form-control-success" placeholder="Success input">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-ctx-danger">Danger</label>
                                <input type="text" id="input-ctx-danger" class="so-form-control so-form-control-danger" placeholder="Danger input">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-ctx-warning">Warning</label>
                                <input type="text" id="input-ctx-warning" class="so-form-control so-form-control-warning" placeholder="Warning input">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-ctx-info">Info</label>
                                <input type="text" id="input-ctx-info" class="so-form-control so-form-control-info" placeholder="Info input">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-ctx-light">Light</label>
                                <input type="text" id="input-ctx-light" class="so-form-control so-form-control-light" placeholder="Light input">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-ctx-dark">Dark</label>
                                <input type="text" id="input-ctx-dark" class="so-form-control so-form-control-dark" placeholder="Dark input">
                            </div>
                        </div>
                        <?= so_code_block('<label class="so-form-label" for="primary">Primary</label>
<input type="text" id="primary" class="so-form-control so-form-control-primary" placeholder="Primary">

<label class="so-form-label" for="secondary">Secondary</label>
<input type="text" id="secondary" class="so-form-control so-form-control-secondary" placeholder="Secondary">

<label class="so-form-label" for="success">Success</label>
<input type="text" id="success" class="so-form-control so-form-control-success" placeholder="Success">

<label class="so-form-label" for="danger">Danger</label>
<input type="text" id="danger" class="so-form-control so-form-control-danger" placeholder="Danger">

<label class="so-form-label" for="warning">Warning</label>
<input type="text" id="warning" class="so-form-control so-form-control-warning" placeholder="Warning">

<label class="so-form-label" for="info">Info</label>
<input type="text" id="info" class="so-form-control so-form-control-info" placeholder="Info">

<label class="so-form-label" for="light">Light</label>
<input type="text" id="light" class="so-form-control so-form-control-light" placeholder="Light">

<label class="so-form-label" for="dark">Dark</label>
<input type="text" id="dark" class="so-form-control so-form-control-dark" placeholder="Dark">', 'html') ?>
                    </div>
                </div>

                <!-- Section 5: Validation States -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Validation States</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
                            <div class="so-form-group has-error" id="emailGroup">
                                <label class="so-form-label" for="input-error-state">Error State</label>
                                <input type="email" id="input-error-state" class="so-form-control" value="invalid-email" aria-describedby="emailError">
                                <div class="so-form-error" id="emailError">
                                    <span class="material-icons">error</span>
                                    Please enter a valid email address
                                </div>
                            </div>

                            <div class="so-form-group has-success" id="usernameGroup">
                                <label class="so-form-label" for="input-success-state">Success State</label>
                                <input type="text" id="input-success-state" class="so-form-control" value="johndoe" aria-describedby="usernameSuccess">
                                <div class="so-form-success" id="usernameSuccess">
                                    <span class="material-icons">check_circle</span>
                                    Username is available
                                </div>
                            </div>

                            <div class="so-form-group has-warning" id="passwordGroup">
                                <label class="so-form-label" for="input-warning-state">Warning State</label>
                                <input type="password" id="input-warning-state" class="so-form-control" value="weak123" aria-describedby="passwordWarning">
                                <div class="so-form-warning" id="passwordWarning">
                                    <span class="material-icons">warning</span>
                                    Password is weak, consider adding special characters
                                </div>
                            </div>

                            <div class="so-form-group has-info" id="phoneGroup">
                                <label class="so-form-label" for="input-info-state">Info State</label>
                                <input type="tel" id="input-info-state" class="so-form-control" placeholder="Enter phone number" aria-describedby="phoneInfo">
                                <div class="so-form-info" id="phoneInfo">
                                    <span class="material-icons">info</span>
                                    We'll send a verification code to this number
                                </div>
                            </div>
                        </div>
                        <div class="so-code-block so-code-block-tabbed so-mt-4">
                            <div class="so-code-header">
                                <div class="so-code-tabs">
                                    <button class="so-code-tab so-active" data-so-target="#validation-states-html">
                                        <span class="material-icons">code</span> HTML
                                    </button>
                                    <button class="so-code-tab" data-so-target="#validation-states-js">
                                        <span class="material-icons">javascript</span> JavaScript
                                    </button>
                                </div>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <div class="so-code-body">
                                <div class="so-code-pane so-active" id="validation-states-html">
                                    <pre class="so-code-content"><code class="language-html">&lt;!-- Error State --&gt;
&lt;div class="so-form-group has-error"&gt;
    &lt;label class="so-form-label" for="email"&gt;Email&lt;/label&gt;
    &lt;input type="email" id="email" class="so-form-control" value="invalid-email" aria-describedby="email-error"&gt;
    &lt;div class="so-form-error" id="email-error"&gt;
        &lt;span class="material-icons"&gt;error&lt;/span&gt;
        Please enter a valid email address
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Success State --&gt;
&lt;div class="so-form-group has-success"&gt;
    &lt;label class="so-form-label" for="username"&gt;Username&lt;/label&gt;
    &lt;input type="text" id="username" class="so-form-control" value="johndoe" aria-describedby="username-success"&gt;
    &lt;div class="so-form-success" id="username-success"&gt;
        &lt;span class="material-icons"&gt;check_circle&lt;/span&gt;
        Username is available
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Warning State --&gt;
&lt;div class="so-form-group has-warning"&gt;
    &lt;label class="so-form-label" for="password"&gt;Password&lt;/label&gt;
    &lt;input type="password" id="password" class="so-form-control" value="weak" aria-describedby="password-warning"&gt;
    &lt;div class="so-form-warning" id="password-warning"&gt;
        &lt;span class="material-icons"&gt;warning&lt;/span&gt;
        Password is weak
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Info State --&gt;
&lt;div class="so-form-group has-info"&gt;
    &lt;label class="so-form-label" for="phone"&gt;Phone&lt;/label&gt;
    &lt;input type="tel" id="phone" class="so-form-control" placeholder="Enter phone" aria-describedby="phone-info"&gt;
    &lt;div class="so-form-info" id="phone-info"&gt;
        &lt;span class="material-icons"&gt;info&lt;/span&gt;
        We'll send a verification code
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                                </div>
                                <div class="so-code-pane" id="validation-states-js">
                                    <pre class="so-code-content"><code class="language-javascript">// Show error state
SOForms.showError('email', 'Please enter a valid email');

// Show success state
SOForms.showSuccess('username', 'Username is available');

// Show warning state
SOForms.showWarning('password', 'Password is weak');

// Show info state
SOForms.showInfo('phone', 'We will send a verification code');

// Clear all validation states
SOForms.clearValidation('email');

// Clear error only
SOForms.clearError('email');</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 6: Help Text & Hints -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Help Text &amp; Hints</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label" for="input-help-text">With Help Text</label>
                                <input type="text" id="input-help-text" class="so-form-control" placeholder="Enter username" aria-describedby="help-text-hint">
                                <div class="so-form-hint" id="help-text-hint">
                                    <span class="material-icons">help_outline</span>
                                    Username must be 3-20 characters long
                                </div>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-char-counter">With Character Counter</label>
                                <input type="text" id="input-char-counter" class="so-form-control" placeholder="Enter bio" maxlength="100" aria-describedby="char-counter-hint">
                                <div class="so-form-hint so-form-hint-counter" id="char-counter-hint">
                                    0 / 100 characters
                                </div>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-inline-hint">
                                    Inline Hint
                                    <span class="so-form-hint so-form-hint-inline">
                                        <span class="material-icons">info</span>
                                        Optional
                                    </span>
                                </label>
                                <input type="text" id="input-inline-hint" class="so-form-control" placeholder="Enter middle name">
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-multi-hints">Multiple Hints</label>
                                <input type="password" id="input-multi-hints" class="so-form-control" placeholder="Create password" aria-describedby="multi-hint-1 multi-hint-2">
                                <div class="so-form-hint" id="multi-hint-1">
                                    <span class="material-icons">lock</span>
                                    Must contain at least 8 characters
                                </div>
                                <div class="so-form-hint" id="multi-hint-2">
                                    <span class="material-icons">security</span>
                                    Include uppercase, lowercase, and numbers
                                </div>
                            </div>
                        </div>
                        <?= so_code_block('<!-- Basic Help Text -->
<div class="so-form-group">
    <label class="so-form-label" for="username">Username</label>
    <input type="text" id="username" class="so-form-control" placeholder="Enter username" aria-describedby="username-hint">
    <div class="so-form-hint" id="username-hint">
        <span class="material-icons">help_outline</span>
        Username must be 3-20 characters long
    </div>
</div>

<!-- Character Counter -->
<div class="so-form-group">
    <label class="so-form-label" for="bio">Bio</label>
    <input type="text" id="bio" class="so-form-control" maxlength="100" aria-describedby="bio-hint">
    <div class="so-form-hint so-form-hint-counter" id="bio-hint">
        0 / 100 characters
    </div>
</div>

<!-- Inline Hint -->
<div class="so-form-group">
    <label class="so-form-label" for="middle-name">
        Middle Name
        <span class="so-form-hint so-form-hint-inline">
            <span class="material-icons">info</span>
            Optional
        </span>
    </label>
    <input type="text" id="middle-name" class="so-form-control">
</div>

<!-- Multiple Hints -->
<div class="so-form-group">
    <label class="so-form-label" for="password">Password</label>
    <input type="password" id="password" class="so-form-control" aria-describedby="hint-1 hint-2">
    <div class="so-form-hint" id="hint-1">Must contain at least 8 characters</div>
    <div class="so-form-hint" id="hint-2">Include uppercase, lowercase, and numbers</div>
</div>', 'html') ?>
                    </div>
                </div>

                <!-- Section 7: Disabled & Readonly -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Disabled &amp; Readonly</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label" for="input-disabled">Disabled Input</label>
                                <input type="text" id="input-disabled" class="so-form-control" value="Cannot edit this" disabled>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="input-readonly">Readonly Input</label>
                                <input type="text" id="input-readonly" class="so-form-control" value="Read only value" readonly>
                            </div>
                        </div>
                        <?= so_code_block('<label class="so-form-label" for="disabled">Disabled</label>
<input type="text" id="disabled" class="so-form-control" value="Cannot edit" disabled>

<label class="so-form-label" for="readonly">Readonly</label>
<input type="text" id="readonly" class="so-form-control" value="Read only" readonly>', 'html') ?>
                    </div>
                </div>

                <!-- Section 8: Textarea -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Textarea</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label" for="textarea-basic">Basic Textarea</label>
                                <textarea id="textarea-basic" class="so-form-control" rows="4" placeholder="Enter description..." aria-describedby="textarea-basic-hint"></textarea>
                                <div class="so-form-hint" id="textarea-basic-hint">
                                    <span class="material-icons">drag_indicator</span>
                                    Drag corner to resize
                                </div>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="textarea-autosize">Autosize Textarea</label>
                                <textarea id="textarea-autosize" class="so-form-control so-form-control-autosize" placeholder="Start typing... height will grow automatically" data-min-height="80" data-max-height="300" aria-describedby="textarea-autosize-hint"></textarea>
                                <div class="so-form-hint" id="textarea-autosize-hint">
                                    <span class="material-icons">expand</span>
                                    Auto-expands as you type (no resize handle)
                                </div>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="textarea-sm">Small Autosize</label>
                                <textarea id="textarea-sm" class="so-form-control so-form-control-autosize-sm" placeholder="Small autosize (60-200px)"></textarea>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="textarea-lg">Large Autosize</label>
                                <textarea id="textarea-lg" class="so-form-control so-form-control-autosize-lg" placeholder="Large autosize (120-600px)"></textarea>
                            </div>
                        </div>

                        <!-- Resize Modifiers -->
                        <h4 class="so-mt-6 so-mb-3">Resize Modifiers</h4>
                        <p class="so-text-muted so-mb-4">Control textarea resize behavior with utility classes.</p>
                        <div class="so-grid so-grid-cols-4 so-grid-cols-md-2 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label" for="textarea-resize-vertical">Vertical Only (Default)</label>
                                <textarea id="textarea-resize-vertical" class="so-form-control so-resize-vertical" rows="3" placeholder="so-resize-vertical"></textarea>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="textarea-resize-none">No Resize</label>
                                <textarea id="textarea-resize-none" class="so-form-control so-resize-none" rows="3" placeholder="so-resize-none"></textarea>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="textarea-resize-horizontal">Horizontal Only</label>
                                <textarea id="textarea-resize-horizontal" class="so-form-control so-resize-horizontal" rows="3" placeholder="so-resize-horizontal"></textarea>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label" for="textarea-resize-both">Both Directions</label>
                                <textarea id="textarea-resize-both" class="so-form-control so-resize-both" rows="3" placeholder="so-resize-both"></textarea>
                            </div>
                        </div>
                        <div class="so-code-block so-code-block-tabbed so-mt-4">
                            <div class="so-code-header">
                                <div class="so-code-tabs">
                                    <button class="so-code-tab so-active" data-so-target="#textarea-html">
                                        <span class="material-icons">code</span> HTML
                                    </button>
                                    <button class="so-code-tab" data-so-target="#textarea-js">
                                        <span class="material-icons">javascript</span> JavaScript
                                    </button>
                                </div>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <div class="so-code-body">
                                <div class="so-code-pane so-active" id="textarea-html">
                                    <pre class="so-code-content"><code class="language-html">&lt;!-- Basic Textarea (with resize) --&gt;
&lt;label class="so-form-label" for="description"&gt;Description&lt;/label&gt;
&lt;textarea id="description" class="so-form-control" rows="4" placeholder="Enter description..."&gt;&lt;/textarea&gt;

&lt;!-- Autosize Textarea (no resize, auto-grows) --&gt;
&lt;label class="so-form-label" for="bio"&gt;Bio&lt;/label&gt;
&lt;textarea id="bio" class="so-form-control so-form-control-autosize"
    placeholder="Start typing..."
    data-min-height="80"
    data-max-height="300"&gt;&lt;/textarea&gt;

&lt;!-- Size Variants --&gt;
&lt;textarea class="so-form-control so-form-control-autosize-sm" placeholder="Small"&gt;&lt;/textarea&gt;
&lt;textarea class="so-form-control so-form-control-autosize-lg" placeholder="Large"&gt;&lt;/textarea&gt;

&lt;!-- Resize Modifiers --&gt;
&lt;textarea class="so-form-control so-resize-vertical" rows="3"&gt;&lt;/textarea&gt; &lt;!-- Default --&gt;
&lt;textarea class="so-form-control so-resize-none" rows="3"&gt;&lt;/textarea&gt;
&lt;textarea class="so-form-control so-resize-horizontal" rows="3"&gt;&lt;/textarea&gt;
&lt;textarea class="so-form-control so-resize-both" rows="3"&gt;&lt;/textarea&gt;</code></pre>
                                </div>
                                <div class="so-code-pane" id="textarea-js">
                                    <pre class="so-code-content"><code class="language-javascript">// Get or create autosize instance
const textarea = document.querySelector('.so-form-control-autosize');
const autosize = SOTextareaAutosize.getInstance(textarea, {
    minHeight: 80,
    maxHeight: 400
});

// Update content programmatically
autosize.update('New content here');

// Listen for resize events
textarea.addEventListener('so:autosize', (e) => {
    console.log('Height:', e.detail.height);
    console.log('Scroll height:', e.detail.scrollHeight);
});

// Destroy instance
autosize.destroy();</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 9: Custom Select - Basic -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Custom Select - Basic</h3>
                        <span class="so-badge so-badge-info">Enhances native &lt;select&gt;</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Simply add <code>data-so-select</code> to any native <code>&lt;select&gt;</code> element to automatically convert it to a custom styled select.</p>
                        <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label">Standard Select</label>
                                <select class="so-form-control" data-so-select>
                                    <option value="">Select an option</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                    <option value="4">Option 4</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">With Pre-selected Value</label>
                                <select class="so-form-control" data-so-select>
                                    <option value="1">Option 1</option>
                                    <option value="2" selected>Option 2</option>
                                    <option value="3">Option 3</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Disabled Select</label>
                                <select class="so-form-control" data-so-select disabled>
                                    <option value="">Cannot select</option>
                                    <option value="1">Option 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="so-code-block so-code-block-tabbed so-mt-4">
                            <div class="so-code-header">
                                <div class="so-code-tabs">
                                    <button class="so-code-tab so-active" data-so-target="#select-basic-html">
                                        <span class="material-icons">code</span> HTML
                                    </button>
                                    <button class="so-code-tab" data-so-target="#select-basic-js">
                                        <span class="material-icons">javascript</span> JavaScript
                                    </button>
                                </div>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <div class="so-code-body">
                                <div class="so-code-pane so-active" id="select-basic-html">
                                    <pre class="so-code-content"><code class="language-html">&lt;!-- Basic Select (recommended) --&gt;
&lt;select class="so-form-control" data-so-select&gt;
    &lt;option value=""&gt;Select an option&lt;/option&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
    &lt;option value="2"&gt;Option 2&lt;/option&gt;
&lt;/select&gt;

&lt;!-- Pre-selected value --&gt;
&lt;select class="so-form-control" data-so-select&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
    &lt;option value="2" selected&gt;Option 2&lt;/option&gt;
&lt;/select&gt;

&lt;!-- Disabled select --&gt;
&lt;select class="so-form-control" data-so-select disabled&gt;
    &lt;option value=""&gt;Cannot select&lt;/option&gt;
&lt;/select&gt;</code></pre>
                                </div>
                                <div class="so-code-pane" id="select-basic-js">
                                    <pre class="so-code-content"><code class="language-javascript">// Auto-initialization (uses data-so-select attribute)
// Just add data-so-select to any &lt;select&gt; element

// Manual initialization
const selectEl = document.querySelector('.so-form-control');
const select = SOSelect.getInstance(selectEl, {
    searchable: false,
    clearable: false,
    placeholder: 'Select an option'
});

// Get/Set value
select.setValue('1');
const value = select.getValue();  // Returns '1'

// Listen to change event
selectEl.addEventListener('so:select:change', (e) => {
    console.log('Selected:', e.detail.value);
});</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 10: Select Sizes -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Select Sizes</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label">Small</label>
                                <select class="so-form-control" data-so-select data-so-size="sm">
                                    <option value="">Small select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Default</label>
                                <select class="so-form-control" data-so-select>
                                    <option value="">Default select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Large</label>
                                <select class="so-form-control" data-so-select data-so-size="lg">
                                    <option value="">Large select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="so-code-block so-code-block-tabbed so-mt-4">
                            <div class="so-code-header">
                                <div class="so-code-tabs">
                                    <button class="so-code-tab so-active" data-so-target="#select-sizes-html">
                                        <span class="material-icons">code</span> HTML
                                    </button>
                                    <button class="so-code-tab" data-so-target="#select-sizes-js">
                                        <span class="material-icons">javascript</span> JavaScript
                                    </button>
                                </div>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <div class="so-code-body">
                                <div class="so-code-pane so-active" id="select-sizes-html">
                                    <pre class="so-code-content"><code class="language-html">&lt;!-- Small --&gt;
&lt;select class="so-form-control" data-so-select data-so-size="sm"&gt;
    &lt;option value=""&gt;Small select&lt;/option&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
&lt;/select&gt;

&lt;!-- Default --&gt;
&lt;select class="so-form-control" data-so-select&gt;
    &lt;option value=""&gt;Default select&lt;/option&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
&lt;/select&gt;

&lt;!-- Large --&gt;
&lt;select class="so-form-control" data-so-select data-so-size="lg"&gt;
    &lt;option value=""&gt;Large select&lt;/option&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
&lt;/select&gt;</code></pre>
                                </div>
                                <div class="so-code-pane" id="select-sizes-js">
                                    <pre class="so-code-content"><code class="language-javascript">// Initialize with size option
const select = SOSelect.getInstance(selectEl, {
    size: 'sm'  // 'sm', null (default), or 'lg'
});</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 11: Searchable Select -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Searchable Select</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label">Searchable</label>
                                <select class="so-form-control" data-so-select data-so-searchable="true" data-so-placeholder="Search countries...">
                                    <option value="">Search countries...</option>
                                    <option value="us">United States</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="de">Germany</option>
                                    <option value="fr">France</option>
                                    <option value="it">Italy</option>
                                    <option value="es">Spain</option>
                                    <option value="jp">Japan</option>
                                    <option value="cn">China</option>
                                    <option value="in">India</option>
                                    <option value="br">Brazil</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Clearable</label>
                                <select class="so-form-control" data-so-select data-so-clearable="true">
                                    <option value="">Select with clear</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="so-code-block so-code-block-tabbed so-mt-4">
                            <div class="so-code-header">
                                <div class="so-code-tabs">
                                    <button class="so-code-tab so-active" data-so-target="#searchable-html">
                                        <span class="material-icons">code</span> HTML
                                    </button>
                                    <button class="so-code-tab" data-so-target="#searchable-js">
                                        <span class="material-icons">javascript</span> JavaScript
                                    </button>
                                </div>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <div class="so-code-body">
                                <div class="so-code-pane so-active" id="searchable-html">
                                    <pre class="so-code-content"><code class="language-html">&lt;!-- Searchable Select --&gt;
&lt;select class="so-form-control" data-so-select data-so-searchable="true"&gt;
    &lt;option value=""&gt;Search...&lt;/option&gt;
    &lt;option value="us"&gt;United States&lt;/option&gt;
    &lt;option value="uk"&gt;United Kingdom&lt;/option&gt;
    ...
&lt;/select&gt;

&lt;!-- Clearable Select --&gt;
&lt;select class="so-form-control" data-so-select data-so-clearable="true"&gt;
    &lt;option value=""&gt;Select with clear&lt;/option&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
&lt;/select&gt;</code></pre>
                                </div>
                                <div class="so-code-pane" id="searchable-js">
                                    <pre class="so-code-content"><code class="language-javascript">// Initialize with searchable and clearable options
const select = SOSelect.getInstance(selectEl, {
    searchable: true,
    searchPlaceholder: 'Type to search...',
    clearable: true,
    noResultsText: 'No matches found'
});

// Listen to search event
selectEl.addEventListener('so:select:search', (e) => {
    console.log('Search query:', e.detail.query);
});

// Listen to clear event
selectEl.addEventListener('so:select:clear', () => {
    console.log('Selection cleared');
});</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 12: Multiple Select -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Multiple Select</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label">Text Display Mode</label>
                                <select class="so-form-control" data-so-select multiple data-so-display-mode="text" data-so-multiple-selected-text="{count} items selected">
                                    <option value="1">Item 1</option>
                                    <option value="2">Item 2</option>
                                    <option value="3">Item 3</option>
                                    <option value="4">Item 4</option>
                                    <option value="5">Item 5</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Chips Display Mode</label>
                                <select class="so-form-control" data-so-select multiple data-so-display-mode="chips">
                                    <option value="1">Apple</option>
                                    <option value="2">Banana</option>
                                    <option value="3">Cherry</option>
                                    <option value="4">Date</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Chips with Overflow (+N more)</label>
                                <select class="so-form-control" data-so-select multiple data-so-display-mode="chips-overflow" data-so-max-visible-chips="2">
                                    <option value="red">Red</option>
                                    <option value="blue">Blue</option>
                                    <option value="green">Green</option>
                                    <option value="yellow">Yellow</option>
                                    <option value="purple">Purple</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">With Select All/None Actions</label>
                                <select class="so-form-control" data-so-select multiple data-so-show-actions="true" data-so-select-all-text="Select All" data-so-select-none-text="Clear">
                                    <option value="important">Important</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="todo">To Do</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="so-code-block so-code-block-tabbed so-mt-4">
                            <div class="so-code-header">
                                <div class="so-code-tabs">
                                    <button class="so-code-tab so-active" data-so-target="#multiple-select-html">
                                        <span class="material-icons">code</span> HTML
                                    </button>
                                    <button class="so-code-tab" data-so-target="#multiple-select-js">
                                        <span class="material-icons">javascript</span> JavaScript
                                    </button>
                                </div>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <div class="so-code-body">
                                <div class="so-code-pane so-active" id="multiple-select-html">
                                    <pre class="so-code-content"><code class="language-html">&lt;!-- Multiple Select with Text Display --&gt;
&lt;select class="so-form-control" data-so-select multiple
        data-so-display-mode="text"
        data-so-multiple-selected-text="{count} items selected"&gt;
    &lt;option value="1"&gt;Item 1&lt;/option&gt;
    &lt;option value="2"&gt;Item 2&lt;/option&gt;
&lt;/select&gt;

&lt;!-- Multiple Select with Chips --&gt;
&lt;select class="so-form-control" data-so-select multiple
        data-so-display-mode="chips"&gt;
    &lt;option value="1"&gt;Apple&lt;/option&gt;
    &lt;option value="2"&gt;Banana&lt;/option&gt;
&lt;/select&gt;

&lt;!-- With Chips Overflow --&gt;
&lt;select class="so-form-control" data-so-select multiple
        data-so-display-mode="chips-overflow"
        data-so-max-visible-chips="2"&gt;
    ...
&lt;/select&gt;

&lt;!-- With Actions Bar --&gt;
&lt;select class="so-form-control" data-so-select multiple
        data-so-show-actions="true"
        data-so-select-all-text="Select All"
        data-so-select-none-text="Clear"&gt;
    ...
&lt;/select&gt;</code></pre>
                                </div>
                                <div class="so-code-pane" id="multiple-select-js">
                                    <pre class="so-code-content"><code class="language-javascript">// Initialize multiple select with options
const select = SOSelect.getInstance(selectEl, {
    multiple: true,
    displayMode: 'chips-overflow',  // 'text', 'chips', 'chips-overflow'
    maxVisibleChips: 3,
    multipleSelectedText: '{count} items selected',
    allSelectedText: 'All {count} items',
    overflowText: '+{count} more',
    showActions: true,
    selectAllText: 'Select All',
    selectNoneText: 'Clear All',
    minSelections: 1,   // Require at least 1 selection
    maxSelections: 5    // Allow max 5 selections
});

// Multi-select API
select.setValues(['1', '2', '3']);
select.addValue('4');
select.removeValue('2');
select.selectAll();
select.selectNone();
const values = select.getValues();  // Returns array</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 13: Grouped Options -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Grouped Options</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label">With Groups (optgroup)</label>
                                <select class="so-form-control" data-so-select data-so-searchable="true">
                                    <option value="">Select a country</option>
                                    <optgroup label="Europe">
                                        <option value="uk">United Kingdom</option>
                                        <option value="de">Germany</option>
                                        <option value="fr">France</option>
                                    </optgroup>
                                    <optgroup label="Asia">
                                        <option value="jp">Japan</option>
                                        <option value="cn">China</option>
                                        <option value="in">India</option>
                                    </optgroup>
                                    <optgroup label="Americas">
                                        <option value="us">United States</option>
                                        <option value="ca">Canada</option>
                                        <option value="br">Brazil</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">With Icons (data attributes)</label>
                                <select class="so-form-control" data-so-select>
                                    <option value="">Select a plan</option>
                                    <option value="free" data-icon="star_outline" data-description="Basic features, 5 users">Free Plan</option>
                                    <option value="pro" data-icon="star_half" data-description="Advanced features, 25 users">Pro Plan</option>
                                    <option value="enterprise" data-icon="star" data-description="All features, unlimited users">Enterprise Plan</option>
                                </select>
                            </div>
                        </div>
                        <div class="so-code-block so-code-block-tabbed so-mt-4">
                            <div class="so-code-header">
                                <div class="so-code-tabs">
                                    <button class="so-code-tab so-active" data-so-target="#grouped-options-html">
                                        <span class="material-icons">code</span> HTML
                                    </button>
                                    <button class="so-code-tab" data-so-target="#grouped-options-js">
                                        <span class="material-icons">javascript</span> JavaScript
                                    </button>
                                </div>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <div class="so-code-body">
                                <div class="so-code-pane so-active" id="grouped-options-html">
                                    <pre class="so-code-content"><code class="language-html">&lt;!-- Grouped Options using optgroup --&gt;
&lt;select class="so-form-control" data-so-select&gt;
    &lt;option value=""&gt;Select a country&lt;/option&gt;
    &lt;optgroup label="Europe"&gt;
        &lt;option value="uk"&gt;United Kingdom&lt;/option&gt;
        &lt;option value="de"&gt;Germany&lt;/option&gt;
    &lt;/optgroup&gt;
    &lt;optgroup label="Asia"&gt;
        &lt;option value="jp"&gt;Japan&lt;/option&gt;
        &lt;option value="cn"&gt;China&lt;/option&gt;
    &lt;/optgroup&gt;
&lt;/select&gt;

&lt;!-- With Icons &amp; Descriptions using data attributes --&gt;
&lt;select class="so-form-control" data-so-select&gt;
    &lt;option value=""&gt;Select a plan&lt;/option&gt;
    &lt;option value="free" data-icon="star_outline" data-description="Basic features"&gt;Free Plan&lt;/option&gt;
    &lt;option value="pro" data-icon="star_half" data-description="Advanced features"&gt;Pro Plan&lt;/option&gt;
&lt;/select&gt;</code></pre>
                                </div>
                                <div class="so-code-pane" id="grouped-options-js">
                                    <pre class="so-code-content"><code class="language-javascript">// Programmatically add options with icons and descriptions
const select = SOSelect.getInstance(selectEl);

// Add option with icon and description
select.addOption({
    value: 'premium',
    label: 'Premium Plan',
    icon: 'workspace_premium',
    description: 'Enterprise features, priority support'
});

// Add a new group with options
select.addGroup('New Region', [
    { value: 'au', label: 'Australia', icon: 'flag' },
    { value: 'nz', label: 'New Zealand', icon: 'flag' }
]);

// Add option to existing group
select.addOptionToGroup({
    value: 'it',
    label: 'Italy',
    icon: 'flag'
}, 'Europe');</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 14: Selection Styles -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Selection Styles</h3>
                        <span class="so-badge so-badge-info">Single & Multiple</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Different indicator styles for showing selected state. Use <strong>radio</strong> styles for single select, <strong>checkbox</strong> for multiple.</p>

                        <h5 class="so-mb-3">Single Select Styles</h5>
                        <div class="so-grid so-grid-cols-5 so-grid-cols-md-3 so-grid-cols-sm-2 so-mb-5">
                            <div class="so-form-group">
                                <label class="so-form-label">icon-bg <span class="so-badge so-badge-sm so-badge-primary">Default</span></label>
                                <select class="so-form-control" data-so-select data-so-selection-style="icon-bg">
                                    <option value="">Select...</option>
                                    <option value="1">Apple</option>
                                    <option value="2">Banana</option>
                                    <option value="3">Cherry</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">icon</label>
                                <select class="so-form-control" data-so-select data-so-selection-style="icon">
                                    <option value="">Select...</option>
                                    <option value="1">Apple</option>
                                    <option value="2">Banana</option>
                                    <option value="3">Cherry</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">bg</label>
                                <select class="so-form-control" data-so-select data-so-selection-style="bg">
                                    <option value="">Select...</option>
                                    <option value="1">Apple</option>
                                    <option value="2">Banana</option>
                                    <option value="3">Cherry</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">radio</label>
                                <select class="so-form-control" data-so-select data-so-selection-style="radio">
                                    <option value="">Select...</option>
                                    <option value="1">Apple</option>
                                    <option value="2">Banana</option>
                                    <option value="3">Cherry</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">radio-bg</label>
                                <select class="so-form-control" data-so-select data-so-selection-style="radio-bg">
                                    <option value="">Select...</option>
                                    <option value="1">Apple</option>
                                    <option value="2">Banana</option>
                                    <option value="3">Cherry</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="so-mb-3">Multiple Select Styles</h5>
                        <div class="so-grid so-grid-cols-5 so-grid-cols-md-3 so-grid-cols-sm-2 so-mb-5">
                            <div class="so-form-group">
                                <label class="so-form-label">icon-bg <span class="so-badge so-badge-sm so-badge-primary">Default</span></label>
                                <select class="so-form-control" data-so-select multiple data-so-selection-style="icon-bg">
                                    <option value="1">Red</option>
                                    <option value="2">Green</option>
                                    <option value="3">Blue</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">icon</label>
                                <select class="so-form-control" data-so-select multiple data-so-selection-style="icon">
                                    <option value="1">Red</option>
                                    <option value="2">Green</option>
                                    <option value="3">Blue</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">bg</label>
                                <select class="so-form-control" data-so-select multiple data-so-selection-style="bg">
                                    <option value="1">Red</option>
                                    <option value="2">Green</option>
                                    <option value="3">Blue</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">checkbox</label>
                                <select class="so-form-control" data-so-select multiple data-so-selection-style="checkbox">
                                    <option value="1">Red</option>
                                    <option value="2">Green</option>
                                    <option value="3">Blue</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">checkbox-bg</label>
                                <select class="so-form-control" data-so-select multiple data-so-selection-style="checkbox-bg">
                                    <option value="1">Red</option>
                                    <option value="2">Green</option>
                                    <option value="3">Blue</option>
                                </select>
                            </div>
                        </div>

                        <div class="so-separator so-separator-lg"></div>

                        <!-- Interactive Style Switcher -->
                        <h5 class="so-mb-3">Interactive Demo - Try Different Styles</h5>
                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1 so-gap-4">
                            <div>
                                <div class="so-form-group so-mb-3">
                                    <label class="so-form-label">Select Mode</label>
                                    <div class="so-d-flex so-gap-2">
                                        <button class="so-btn so-btn-primary so-btn-sm" id="style-demo-single-btn" onclick="styleDemoSetMode('single')">Single</button>
                                        <button class="so-btn so-btn-outline-primary so-btn-sm" id="style-demo-multi-btn" onclick="styleDemoSetMode('multiple')">Multiple</button>
                                    </div>
                                </div>
                                <div class="so-form-group">
                                    <label class="so-form-label">Selection Style</label>
                                    <div class="so-d-flex so-flex-wrap so-gap-2" id="style-buttons-container">
                                        <button class="so-btn so-btn-dark so-btn-sm" onclick="styleDemoSetStyle('icon-bg')">icon-bg</button>
                                        <button class="so-btn so-btn-outline-dark so-btn-sm" onclick="styleDemoSetStyle('icon')">icon</button>
                                        <button class="so-btn so-btn-outline-dark so-btn-sm" onclick="styleDemoSetStyle('bg')">bg</button>
                                        <button class="so-btn so-btn-outline-dark so-btn-sm style-radio-btn" onclick="styleDemoSetStyle('radio')">radio</button>
                                        <button class="so-btn so-btn-outline-dark so-btn-sm style-radio-btn" onclick="styleDemoSetStyle('radio-bg')">radio-bg</button>
                                        <button class="so-btn so-btn-outline-dark so-btn-sm style-checkbox-btn" onclick="styleDemoSetStyle('checkbox')" style="display:none;">checkbox</button>
                                        <button class="so-btn so-btn-outline-dark so-btn-sm style-checkbox-btn" onclick="styleDemoSetStyle('checkbox-bg')" style="display:none;">checkbox-bg</button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="so-form-label">Live Preview</label>
                                <div id="style-demo-container">
                                    <select id="style-demo-select" class="so-form-control" data-so-select data-so-selection-style="icon-bg">
                                        <option value="">Select a country...</option>
                                        <option value="us" data-icon="flag">United States</option>
                                        <option value="uk" data-icon="flag">United Kingdom</option>
                                        <option value="de" data-icon="flag">Germany</option>
                                        <option value="fr" data-icon="flag">France</option>
                                        <option value="jp" data-icon="flag">Japan</option>
                                    </select>
                                </div>
                                <div class="so-mt-2 so-text-muted so-text-sm" id="style-demo-info">
                                    Mode: <strong>Single</strong> | Style: <strong>icon-bg</strong>
                                </div>
                            </div>
                        </div>

                        <script>
                            let currentStyleDemoMode = 'single';
                            let currentStyleDemoStyle = 'icon-bg';

                            function styleDemoSetMode(mode) {
                                currentStyleDemoMode = mode;
                                // Update buttons
                                document.getElementById('style-demo-single-btn').className = mode === 'single' ? 'so-btn so-btn-primary so-btn-sm' : 'so-btn so-btn-outline-primary so-btn-sm';
                                document.getElementById('style-demo-multi-btn').className = mode === 'multiple' ? 'so-btn so-btn-primary so-btn-sm' : 'so-btn so-btn-outline-primary so-btn-sm';

                                // Show/hide style buttons based on mode
                                const radioBtns = document.querySelectorAll('.style-radio-btn');
                                const checkboxBtns = document.querySelectorAll('.style-checkbox-btn');
                                radioBtns.forEach(btn => btn.style.display = mode === 'single' ? '' : 'none');
                                checkboxBtns.forEach(btn => btn.style.display = mode === 'multiple' ? '' : 'none');

                                // Reset to appropriate default style
                                if (mode === 'multiple' && (currentStyleDemoStyle === 'radio' || currentStyleDemoStyle === 'radio-bg')) {
                                    styleDemoSetStyle('icon-bg');
                                } else if (mode === 'single' && (currentStyleDemoStyle === 'checkbox' || currentStyleDemoStyle === 'checkbox-bg')) {
                                    styleDemoSetStyle('icon-bg');
                                } else {
                                    styleDemoRebuild();
                                }
                            }

                            function styleDemoSetStyle(style) {
                                currentStyleDemoStyle = style;
                                // Update style buttons
                                document.querySelectorAll('#style-buttons-container button').forEach(btn => {
                                    if (btn.textContent === style) {
                                        btn.className = btn.className.replace('so-btn-outline-dark', 'so-btn-dark');
                                    } else {
                                        btn.className = btn.className.replace('so-btn-dark', 'so-btn-outline-dark');
                                    }
                                });
                                styleDemoRebuild();
                            }

                            function styleDemoRebuild() {
                                const container = document.getElementById('style-demo-container');
                                const isMultiple = currentStyleDemoMode === 'multiple';

                                // Rebuild the select
                                container.innerHTML = `
                                    <select id="style-demo-select" class="so-form-control" data-so-select
                                            ${isMultiple ? 'multiple' : ''}
                                            data-so-selection-style="${currentStyleDemoStyle}">
                                        ${isMultiple ? '' : '<option value="">Select a country...</option>'}
                                        <option value="us" data-icon="flag">United States</option>
                                        <option value="uk" data-icon="flag">United Kingdom</option>
                                        <option value="de" data-icon="flag">Germany</option>
                                        <option value="fr" data-icon="flag">France</option>
                                        <option value="jp" data-icon="flag">Japan</option>
                                    </select>
                                `;

                                // Initialize the new select
                                const newSelect = document.getElementById('style-demo-select');
                                SOSelect.getInstance(newSelect);

                                // Update info
                                document.getElementById('style-demo-info').innerHTML =
                                    `Mode: <strong>${isMultiple ? 'Multiple' : 'Single'}</strong> | Style: <strong>${currentStyleDemoStyle}</strong>`;
                            }
                        </script>

                        <div class="so-code-block so-code-block-tabbed so-mt-4">
                            <div class="so-code-header">
                                <div class="so-code-tabs">
                                    <button class="so-code-tab so-active" data-so-target="#selection-styles-html">
                                        <span class="material-icons">code</span> HTML
                                    </button>
                                    <button class="so-code-tab" data-so-target="#selection-styles-js">
                                        <span class="material-icons">javascript</span> JavaScript
                                    </button>
                                </div>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <div class="so-code-body">
                                <div class="so-code-pane so-active" id="selection-styles-html">
                                    <pre class="so-code-content"><code class="language-html">&lt;!-- Selection Styles --&gt;
&lt;!-- For multiple: checkbox, checkbox-bg, icon, bg, icon-bg --&gt;
&lt;!-- For single: radio, radio-bg, icon, bg, icon-bg --&gt;

&lt;!-- Icon + Background (default) --&gt;
&lt;select class="so-form-control" data-so-select data-so-selection-style="icon-bg"&gt;
    &lt;option value=""&gt;Select...&lt;/option&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
&lt;/select&gt;

&lt;!-- Checkbox Style (for multi-select) --&gt;
&lt;select class="so-form-control" data-so-select multiple data-so-selection-style="checkbox"&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
    &lt;option value="2"&gt;Option 2&lt;/option&gt;
&lt;/select&gt;

&lt;!-- Radio Style (for single select) --&gt;
&lt;select class="so-form-control" data-so-select data-so-selection-style="radio"&gt;
    &lt;option value=""&gt;Select...&lt;/option&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
&lt;/select&gt;

&lt;!-- Radio with Background --&gt;
&lt;select class="so-form-control" data-so-select data-so-selection-style="radio-bg"&gt;
    &lt;option value=""&gt;Select...&lt;/option&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
&lt;/select&gt;

&lt;!-- Background Only Style --&gt;
&lt;select class="so-form-control" data-so-select data-so-selection-style="bg"&gt;
    &lt;option value=""&gt;Select...&lt;/option&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
&lt;/select&gt;</code></pre>
                                </div>
                                <div class="so-code-pane" id="selection-styles-js">
                                    <pre class="so-code-content"><code class="language-javascript">// Initialize with selection style options
const select = SOSelect.getInstance(selectEl, {
    // For multiple: 'checkbox', 'checkbox-bg', 'icon', 'bg', 'icon-bg'
    // For single: 'radio', 'radio-bg', 'icon', 'bg', 'icon-bg'
    selectionStyle: 'radio-bg',
    selectionIcon: 'done'  // Only used with icon/icon-bg styles
});</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 15: Contextual Colors -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Contextual Colors</h3>
                    </div>
                    <div class="so-card-body">
                        <div class="so-grid so-grid-cols-4 so-grid-cols-md-2 so-grid-cols-sm-1">
                            <div class="so-form-group">
                                <label class="so-form-label">Primary</label>
                                <select class="so-form-control" data-so-select data-so-variant="primary">
                                    <option value="">Primary select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Secondary</label>
                                <select class="so-form-control" data-so-select data-so-variant="secondary">
                                    <option value="">Secondary select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Success</label>
                                <select class="so-form-control" data-so-select data-so-variant="success">
                                    <option value="">Success select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Danger</label>
                                <select class="so-form-control" data-so-select data-so-variant="danger">
                                    <option value="">Danger select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Warning</label>
                                <select class="so-form-control" data-so-select data-so-variant="warning">
                                    <option value="">Warning select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Info</label>
                                <select class="so-form-control" data-so-select data-so-variant="info">
                                    <option value="">Info select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Light</label>
                                <select class="so-form-control" data-so-select data-so-variant="light">
                                    <option value="">Light select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>

                            <div class="so-form-group">
                                <label class="so-form-label">Dark</label>
                                <select class="so-form-control" data-so-select data-so-variant="dark">
                                    <option value="">Dark select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="so-code-block so-code-block-tabbed so-mt-4">
                            <div class="so-code-header">
                                <div class="so-code-tabs">
                                    <button class="so-code-tab so-active" data-so-target="#contextual-colors-html">
                                        <span class="material-icons">code</span> HTML
                                    </button>
                                    <button class="so-code-tab" data-so-target="#contextual-colors-js">
                                        <span class="material-icons">javascript</span> JavaScript
                                    </button>
                                </div>
                                <button class="so-code-copy" onclick="copyCode(this)">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                            <div class="so-code-body">
                                <div class="so-code-pane so-active" id="contextual-colors-html">
                                    <pre class="so-code-content"><code class="language-html">&lt;!-- Contextual Colors using data-so-variant --&gt;
&lt;select class="so-form-control" data-so-select data-so-variant="primary"&gt;
    &lt;option value=""&gt;Primary select&lt;/option&gt;
    &lt;option value="1"&gt;Option 1&lt;/option&gt;
&lt;/select&gt;

&lt;select class="so-form-control" data-so-select data-so-variant="secondary"&gt;...&lt;/select&gt;
&lt;select class="so-form-control" data-so-select data-so-variant="success"&gt;...&lt;/select&gt;
&lt;select class="so-form-control" data-so-select data-so-variant="danger"&gt;...&lt;/select&gt;
&lt;select class="so-form-control" data-so-select data-so-variant="warning"&gt;...&lt;/select&gt;
&lt;select class="so-form-control" data-so-select data-so-variant="info"&gt;...&lt;/select&gt;
&lt;select class="so-form-control" data-so-select data-so-variant="light"&gt;...&lt;/select&gt;
&lt;select class="so-form-control" data-so-select data-so-variant="dark"&gt;...&lt;/select&gt;</code></pre>
                                </div>
                                <div class="so-code-pane" id="contextual-colors-js">
                                    <pre class="so-code-content"><code class="language-javascript">// Initialize with variant option
const select = SOSelect.getInstance(selectEl, {
    variant: 'primary'  // 'primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'
});</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 16: Interactive Demo -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">Interactive JavaScript Demo</h3>
                        <span class="so-badge so-badge-primary">Try it!</span>
                    </div>
                    <div class="so-card-body">
                        <p class="so-text-muted so-mb-4">Use the buttons below to interact with the select component programmatically.</p>

                        <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1 so-gap-4">
                            <div>
                                <label class="so-form-label">Demo Select (Single)</label>
                                <select id="demo-select-single" class="so-form-control" data-so-select data-so-clearable="true">
                                    <option value="">Select a fruit</option>
                                    <option value="apple">Apple</option>
                                    <option value="banana">Banana</option>
                                    <option value="cherry">Cherry</option>
                                    <option value="date">Date</option>
                                    <option value="elderberry">Elderberry</option>
                                </select>
                            </div>
                            <div>
                                <label class="so-form-label">Demo Select (Multiple)</label>
                                <select id="demo-select-multiple" class="so-form-control" data-so-select multiple data-so-display-mode="chips" data-so-show-actions="true">
                                    <option value="red">Red</option>
                                    <option value="blue">Blue</option>
                                    <option value="green">Green</option>
                                    <option value="yellow">Yellow</option>
                                    <option value="purple">Purple</option>
                                </select>
                            </div>
                        </div>

                        <div class="so-separator so-separator-lg"></div>

                        <h5 class="so-mb-3">Value Operations</h5>
                        <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-4">
                            <button class="so-btn so-btn-primary so-btn-sm" onclick="demoSetValue('banana')">Set Value: Banana</button>
                            <button class="so-btn so-btn-primary so-btn-sm" onclick="demoSetValue('cherry')">Set Value: Cherry</button>
                            <button class="so-btn so-btn-outline-primary so-btn-sm" onclick="demoGetValue()">Get Value</button>
                            <button class="so-btn so-btn-outline-danger so-btn-sm" onclick="demoClear()">Clear</button>
                        </div>

                        <h5 class="so-mb-3">Multiple Select Operations</h5>
                        <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-4">
                            <button class="so-btn so-btn-success so-btn-sm" onclick="demoSetMultiple(['red', 'blue'])">Set: Red, Blue</button>
                            <button class="so-btn so-btn-success so-btn-sm" onclick="demoAddValue('green')">Add: Green</button>
                            <button class="so-btn so-btn-warning so-btn-sm" onclick="demoRemoveValue('red')">Remove: Red</button>
                            <button class="so-btn so-btn-info so-btn-sm" onclick="demoSelectAll()">Select All</button>
                            <button class="so-btn so-btn-outline-secondary so-btn-sm" onclick="demoSelectNone()">Select None</button>
                            <button class="so-btn so-btn-outline-primary so-btn-sm" onclick="demoGetMultipleValues()">Get Values</button>
                        </div>

                        <h5 class="so-mb-3">Option Management</h5>
                        <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-4">
                            <button class="so-btn so-btn-secondary so-btn-sm" onclick="demoAddOption()">Add: Mango</button>
                            <button class="so-btn so-btn-secondary so-btn-sm" onclick="demoRemoveOption()">Remove: Date</button>
                            <button class="so-btn so-btn-secondary so-btn-sm" onclick="demoUpdateOption()">Update: Apple → Green Apple</button>
                        </div>

                        <h5 class="so-mb-3">State Control</h5>
                        <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-4">
                            <button class="so-btn so-btn-dark so-btn-sm" onclick="demoDisable()">Disable</button>
                            <button class="so-btn so-btn-light so-btn-sm" onclick="demoEnable()">Enable</button>
                            <button class="so-btn so-btn-outline-dark so-btn-sm" onclick="demoOpen()">Open</button>
                            <button class="so-btn so-btn-outline-dark so-btn-sm" onclick="demoClose()">Close</button>
                        </div>

                        <div class="so-separator"></div>

                        <h5 class="so-mb-3">Output Log</h5>
                        <div id="demo-output" class="so-bg-light so-p-3 so-rounded" style="min-height: 80px; font-family: monospace; font-size: 13px;">
                            <span class="so-text-muted">Click buttons above to see the output...</span>
                        </div>
                    </div>
                </div>

                <script>
                    // Demo helper functions
                    function logOutput(message) {
                        const output = document.getElementById('demo-output');
                        const timestamp = new Date().toLocaleTimeString();
                        output.innerHTML = `<div class="so-text-primary">[${timestamp}]</div>${message}`;
                    }

                    function getSingleSelect() {
                        const el = document.getElementById('demo-select-single');
                        if (!el) {
                            logOutput('<span class="so-text-danger">Error: demo-select-single element not found</span>');
                            return null;
                        }
                        const select = SOSelect.getInstance(el);
                        if (!select) {
                            logOutput('<span class="so-text-danger">Error: SOSelect instance not found for single select</span>');
                            return null;
                        }
                        return select;
                    }

                    function getMultipleSelect() {
                        const el = document.getElementById('demo-select-multiple');
                        if (!el) {
                            logOutput('<span class="so-text-danger">Error: demo-select-multiple element not found</span>');
                            return null;
                        }
                        const select = SOSelect.getInstance(el);
                        if (!select) {
                            logOutput('<span class="so-text-danger">Error: SOSelect instance not found for multiple select</span>');
                            return null;
                        }
                        return select;
                    }

                    // Single Select Operations
                    function demoSetValue(value) {
                        const select = getSingleSelect();
                        if (select) {
                            select.setValue(value);
                            logOutput(`setValue('${value}')<br>Current value: <strong>${select.getValue()}</strong><br>Display text: <strong>${select.getText()}</strong>`);
                        }
                    }

                    function demoGetValue() {
                        const select = getSingleSelect();
                        if (select) {
                            const value = select.getValue();
                            const text = select.getText();
                            logOutput(`getValue(): <strong>${value || '(empty)'}</strong><br>getText(): <strong>${text || '(empty)'}</strong>`);
                        }
                    }

                    function demoClear() {
                        const select = getSingleSelect();
                        if (select) {
                            select.clear();
                            logOutput(`clear()<br>Value cleared!`);
                        }
                    }

                    // Multiple Select Operations
                    function demoSetMultiple(values) {
                        const select = getMultipleSelect();
                        if (select) {
                            select.setValues(values);
                            logOutput(`setValues([${values.map(v => `'${v}'`).join(', ')}])<br>Current values: <strong>${JSON.stringify(select.getValues())}</strong>`);
                        }
                    }

                    function demoAddValue(value) {
                        const select = getMultipleSelect();
                        if (select) {
                            select.addValue(value);
                            logOutput(`addValue('${value}')<br>Current values: <strong>${JSON.stringify(select.getValues())}</strong>`);
                        }
                    }

                    function demoRemoveValue(value) {
                        const select = getMultipleSelect();
                        if (select) {
                            select.removeValue(value);
                            logOutput(`removeValue('${value}')<br>Current values: <strong>${JSON.stringify(select.getValues())}</strong>`);
                        }
                    }

                    function demoSelectAll() {
                        const select = getMultipleSelect();
                        if (select) {
                            select.selectAll();
                            logOutput(`selectAll()<br>Current values: <strong>${JSON.stringify(select.getValues())}</strong>`);
                        }
                    }

                    function demoSelectNone() {
                        const select = getMultipleSelect();
                        if (select) {
                            select.selectNone();
                            logOutput(`selectNone()<br>Current values: <strong>${JSON.stringify(select.getValues())}</strong>`);
                        }
                    }

                    function demoGetMultipleValues() {
                        const select = getMultipleSelect();
                        if (select) {
                            const values = select.getValues();
                            const texts = select.getTexts();
                            logOutput(`getValues(): <strong>${JSON.stringify(values)}</strong><br>getTexts(): <strong>${JSON.stringify(texts)}</strong>`);
                        }
                    }

                    // Option Management
                    function demoAddOption() {
                        const select = getSingleSelect();
                        if (select) {
                            if (!select.hasOption('mango')) {
                                select.addOption({ value: 'mango', label: 'Mango' });
                                logOutput(`addOption({ value: 'mango', label: 'Mango' })<br>Option "Mango" added!`);
                            } else {
                                logOutput(`Option "Mango" already exists!`);
                            }
                        }
                    }

                    function demoRemoveOption() {
                        const select = getSingleSelect();
                        if (select) {
                            if (select.hasOption('date')) {
                                select.removeOption('date');
                                logOutput(`removeOption('date')<br>Option "Date" removed!`);
                            } else {
                                logOutput(`Option "Date" doesn't exist or already removed!`);
                            }
                        }
                    }

                    function demoUpdateOption() {
                        const select = getSingleSelect();
                        if (select) {
                            if (select.hasOption('apple')) {
                                select.updateOption('apple', { label: 'Green Apple' });
                                logOutput(`updateOption('apple', { label: 'Green Apple' })<br>Option updated!`);
                            } else {
                                logOutput(`Option "Apple" doesn't exist!`);
                            }
                        }
                    }

                    // State Control
                    function demoDisable() {
                        const select = getSingleSelect();
                        if (select) {
                            select.disable();
                            logOutput(`disable()<br>Select is now disabled!`);
                        }
                    }

                    function demoEnable() {
                        const select = getSingleSelect();
                        if (select) {
                            select.enable();
                            logOutput(`enable()<br>Select is now enabled!`);
                        }
                    }

                    function demoOpen() {
                        const select = getSingleSelect();
                        if (select) {
                            select.open();
                            logOutput(`open()<br>Dropdown opened!`);
                        }
                    }

                    function demoClose() {
                        const select = getSingleSelect();
                        if (select) {
                            select.close();
                            logOutput(`close()<br>Dropdown closed!`);
                        }
                    }

                    // Listen to events
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(() => {
                            const singleEl = document.getElementById('demo-select-single');
                            const multiEl = document.getElementById('demo-select-multiple');

                            if (singleEl && singleEl.nextElementSibling) {
                                singleEl.nextElementSibling.addEventListener('so:select:change', (e) => {
                                    console.log('Single select changed:', e.detail);
                                });
                            }

                            if (multiEl && multiEl.nextElementSibling) {
                                multiEl.nextElementSibling.addEventListener('so:select:change', (e) => {
                                    console.log('Multiple select changed:', e.detail);
                                });
                            }
                        }, 500);
                    });
                </script>

                <!-- Section 17: JavaScript API -->
                <div class="so-card so-mb-4">
                    <div class="so-card-header">
                        <h3 class="so-card-title">JavaScript API Reference</h3>
                    </div>
                    <div class="so-card-body">
                        <h4 class="so-mb-3">Initialization</h4>
                        <?= so_code_block('// Auto-initialize via data attribute (done automatically)
// Or manually get/create instance:
const selectEl = document.querySelector(\'.so-select\');
const select = SOSelect.getInstance(selectEl, {
    searchable: true,
    multiple: true,
    displayMode: \'chips\',
    showActions: true,
    selectAllText: \'Select All\',
    selectNoneText: \'Clear All\',
    multipleSelectedText: \'{count} items selected\',
    allSelectedText: \'All items selected\'
});', 'javascript') ?>

                        <h4 class="so-mt-4 so-mb-3">Value Management</h4>
                        <?= so_code_block('// Get values
const value = select.getValue();    // Single value or first
const values = select.getValues();  // Array of all selected
const text = select.getText();      // Display text
const texts = select.getTexts();    // Array of texts

// Set values
select.setValue(\'us\');              // Single value
select.setValues([\'us\', \'uk\']);     // Multiple values
select.addValue(\'de\');              // Add to selection
select.removeValue(\'us\');           // Remove from selection
select.clear();                     // Clear all
select.selectAll();                 // Select all (multi)
select.selectNone();                // Deselect all (multi)', 'javascript') ?>

                        <h4 class="so-mt-4 so-mb-3">Programmatic Option Management</h4>
                        <?= so_code_block('// Add options
select.addOption({ value: \'new\', label: \'New Option\' });
select.prependOption({ value: \'first\', label: \'First\' });
select.addOptionAt({ value: \'mid\', label: \'Middle\' }, 2);
select.addOptionBefore({ value: \'x\', label: \'Before UK\' }, \'uk\');
select.addOptionAfter({ value: \'y\', label: \'After US\' }, \'us\');

// Add to groups
select.addOptionToGroup({ value: \'fr\', label: \'France\' }, \'Europe\');
select.addGroup(\'Oceania\', [
    { value: \'au\', label: \'Australia\' },
    { value: \'nz\', label: \'New Zealand\' }
]);

// Remove options
select.removeOption(\'us\');
select.removeGroup(\'Europe\');
select.clearOptions();

// Update options
select.updateOption(\'uk\', { label: \'United Kingdom (Updated)\' });', 'javascript') ?>

                        <h4 class="so-mt-4 so-mb-3">Events</h4>
                        <?= so_code_block('const selectEl = document.querySelector(\'.so-select\');

// Change event
selectEl.addEventListener(\'so:select:change\', (e) => {
    console.log(\'Selected value:\', e.detail.value);
    console.log(\'All values:\', e.detail.values);
    console.log(\'Previous values:\', e.detail.previousValues);
    console.log(\'Action:\', e.detail.action); // \'select\', \'deselect\', \'clear\', \'selectAll\'
});

// Search event
selectEl.addEventListener(\'so:select:search\', (e) => {
    console.log(\'Search query:\', e.detail.query);
});

// Open/Close events
selectEl.addEventListener(\'so:select:open\', () => console.log(\'Opening\'));
selectEl.addEventListener(\'so:select:opened\', () => console.log(\'Opened\'));
selectEl.addEventListener(\'so:select:close\', () => console.log(\'Closing\'));
selectEl.addEventListener(\'so:select:closed\', () => console.log(\'Closed\'));
selectEl.addEventListener(\'so:select:clear\', () => console.log(\'Cleared\'));', 'javascript') ?>

                        <h4 class="so-mt-4 so-mb-3">Control Methods</h4>
                        <?= so_code_block('// Dropdown control
select.open();
select.close();
select.toggle();

// State control
select.enable();
select.disable();
select.setOptionDisabled(\'us\', true);  // Disable specific option

// Check state
select.isOpen();
select.isDisabled();
select.hasOption(\'us\');
select.getOption(\'us\');  // Returns option object', 'javascript') ?>
                    </div>
                </div>
    </div>

    <!-- Helper Scripts -->
    <script>
        // Password visibility toggle for demo
        function togglePasswordVisibility(btn) {
            const input = btn.previousElementSibling;
            const icon = btn.querySelector('.material-icons');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</main>

<?php
require_once '../includes/footer.php';
?>
