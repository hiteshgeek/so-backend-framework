<?php
/**
 * SixOrbit UI Demo - Form Validation
 */
$pageTitle = 'Form Validation';
$pageDescription = 'Validation states, error messages, and interactive validation examples';

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
            <h1 class="so-page-title"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="so-page-subtitle"><?= htmlspecialchars($pageDescription) ?></p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

        <!-- ===================== VALIDATION STATES ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation States</h3>
                <p class="so-card-subtitle">Apply <code>has-error</code>, <code>has-success</code>, <code>has-warning</code>, or <code>has-info</code> classes to the form group.</p>
            </div>
            <div class="so-card-body">
                        <div class="so-form-row">
                            <div class="so-form-group has-success">
                                <label class="so-form-label">Success</label>
                                <div class="so-input-wrapper so-show-success-icon">
                                    <input type="text" class="so-form-control" value="Valid value">
                                    <span class="so-input-icon"><span class="material-icons">person</span></span>
                                </div>
                                <span class="so-form-success"><span class="material-icons">check_circle</span> Looks good!</span>
                            </div>
                            <div class="so-form-group has-error">
                                <label class="so-form-label">Error</label>
                                <div class="so-input-wrapper so-show-error-icon">
                                    <input type="email" class="so-form-control" value="invalid-email">
                                    <span class="so-input-icon"><span class="material-icons">email</span></span>
                                </div>
                                <span class="so-form-error"><span class="material-icons">error</span> Please enter a valid email</span>
                            </div>
                        </div>
                        <div class="so-form-row">
                            <div class="so-form-group has-warning">
                                <label class="so-form-label">Warning</label>
                                <input type="text" class="so-form-control" value="Weak password">
                                <span class="so-form-warning"><span class="material-icons">warning</span> Password is too weak</span>
                            </div>
                            <div class="so-form-group has-info">
                                <label class="so-form-label">Info</label>
                                <input type="text" class="so-form-control" value="username123">
                                <span class="so-form-info"><span class="material-icons">info</span> Username is available</span>
                            </div>
                        </div>
                    <div class="so-code-block">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <pre class="so-code-content"><code class="language-html">&lt;!-- Success State --&gt;
&lt;div class="so-form-group has-success"&gt;
    &lt;label class="so-form-label"&gt;Success&lt;/label&gt;
    &lt;div class="so-input-wrapper so-show-success-icon"&gt;
        &lt;input type="text" class="so-form-control" value="Valid value"&gt;
        &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;person&lt;/span&gt;&lt;/span&gt;
    &lt;/div&gt;
    &lt;span class="so-form-success"&gt;
        &lt;span class="material-icons"&gt;check_circle&lt;/span&gt; Looks good!
    &lt;/span&gt;
&lt;/div&gt;

&lt;!-- Error State --&gt;
&lt;div class="so-form-group has-error"&gt;
    &lt;label class="so-form-label"&gt;Error&lt;/label&gt;
    &lt;div class="so-input-wrapper so-show-error-icon"&gt;
        &lt;input type="email" class="so-form-control" value="invalid-email"&gt;
        &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;email&lt;/span&gt;&lt;/span&gt;
    &lt;/div&gt;
    &lt;span class="so-form-error"&gt;
        &lt;span class="material-icons"&gt;error&lt;/span&gt; Please enter a valid email
    &lt;/span&gt;
&lt;/div&gt;

&lt;!-- Warning State --&gt;
&lt;div class="so-form-group has-warning"&gt;
    &lt;label class="so-form-label"&gt;Warning&lt;/label&gt;
    &lt;input type="text" class="so-form-control" value="Weak password"&gt;
    &lt;span class="so-form-warning"&gt;
        &lt;span class="material-icons"&gt;warning&lt;/span&gt; Password is too weak
    &lt;/span&gt;
&lt;/div&gt;

&lt;!-- Info State --&gt;
&lt;div class="so-form-group has-info"&gt;
    &lt;label class="so-form-label"&gt;Info&lt;/label&gt;
    &lt;input type="text" class="so-form-control" value="username123"&gt;
    &lt;span class="so-form-info"&gt;
        &lt;span class="material-icons"&gt;info&lt;/span&gt; Username is available
    &lt;/span&gt;
&lt;/div&gt;</code></pre>
                    </div>
            </div>
        </div>

        <!-- ===================== SHAKE ANIMATION ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Error Animation</h3>
                <p class="so-card-subtitle">Add <code>so-shake</code> class to trigger a shake animation on errors.</p>
            </div>
            <div class="so-card-body">
                        <div class="so-form-group has-error" id="shakeDemo">
                            <label class="so-form-label">Required Field</label>
                            <input type="text" class="so-form-control" placeholder="Leave empty and click button">
                            <span class="so-form-error"><span class="material-icons">error</span> This field is required</span>
                        </div>
                        <button type="button" class="so-btn so-btn-danger" onclick="triggerShake()">
                            <span class="material-icons">error_outline</span>
                            Trigger Shake
                        </button>
                    <div class="so-code-block so-code-block-tabbed">
                        <div class="so-code-header">
                            <div class="so-code-tabs">
                                <button class="so-code-tab so-active" data-so-target="#shake-html">
                                    <span class="material-icons">code</span> HTML
                                </button>
                                <button class="so-code-tab" data-so-target="#shake-js">
                                    <span class="material-icons">javascript</span> JavaScript
                                </button>
                            </div>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <div class="so-code-body">
                            <div class="so-code-pane so-active" id="shake-html">
                                <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group has-error" id="shakeDemo"&gt;
    &lt;label class="so-form-label"&gt;Required Field&lt;/label&gt;
    &lt;input type="text" class="so-form-control" placeholder="Leave empty and click button"&gt;
    &lt;span class="so-form-error"&gt;
        &lt;span class="material-icons"&gt;error&lt;/span&gt; This field is required
    &lt;/span&gt;
&lt;/div&gt;

&lt;button type="button" class="so-btn so-btn-danger" onclick="triggerShake()"&gt;
    &lt;span class="material-icons"&gt;error_outline&lt;/span&gt;
    Trigger Shake
&lt;/button&gt;</code></pre>
                            </div>
                            <div class="so-code-pane" id="shake-js">
                                <pre class="so-code-content"><code class="language-javascript">function triggerShake() {
    var el = document.getElementById('shakeDemo');

    // Remove class first to allow re-triggering
    el.classList.remove('so-shake');

    // Trigger reflow to restart animation
    void el.offsetWidth;

    // Add shake class
    el.classList.add('so-shake');
}

// Alternative: Auto-remove shake class after animation
el.addEventListener('animationend', function() {
    el.classList.remove('so-shake');
});</code></pre>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <!-- ===================== INPUT HINTS ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Input Hints</h3>
                <p class="so-card-subtitle">Use hints to show helper text, character counters, or requirements.</p>
            </div>
            <div class="so-card-body">
                        <div class="so-form-group">
                            <label class="so-form-label">Bio</label>
                            <textarea class="so-form-control" rows="3" maxlength="150" placeholder="Tell us about yourself..." id="bioTextarea"></textarea>
                            <div class="so-form-hints">
                                <span class="so-form-hint so-form-hint-left">Keep it brief and friendly</span>
                                <span class="so-form-char-counter so-form-hint-right" id="bioCounter">0/150</span>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Username</label>
                            <input type="text" class="so-form-control" maxlength="20" placeholder="Choose a username" id="usernameInput">
                            <div class="so-form-hints">
                                <span class="so-form-hint so-form-hint-left">Only letters, numbers, and underscores</span>
                                <span class="so-form-char-counter so-form-hint-right" id="usernameCounter">0/20</span>
                            </div>
                        </div>
                    <div class="so-code-block">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <pre class="so-code-content"><code class="language-html">&lt;!-- Textarea with Character Counter --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Bio&lt;/label&gt;
    &lt;textarea class="so-form-control" rows="3" maxlength="150"
        placeholder="Tell us about yourself..."&gt;&lt;/textarea&gt;
    &lt;div class="so-form-hints"&gt;
        &lt;span class="so-form-hint so-form-hint-left"&gt;Keep it brief and friendly&lt;/span&gt;
        &lt;span class="so-form-char-counter so-form-hint-right" id="bioCounter"&gt;0/150&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Input with Character Counter --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Username&lt;/label&gt;
    &lt;input type="text" class="so-form-control" maxlength="20"
        placeholder="Choose a username"&gt;
    &lt;div class="so-form-hints"&gt;
        &lt;span class="so-form-hint so-form-hint-left"&gt;Only letters, numbers, and underscores&lt;/span&gt;
        &lt;span class="so-form-char-counter so-form-hint-right" id="usernameCounter"&gt;0/20&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
            </div>
        </div>

        <!-- ===================== INTERACTIVE VALIDATION DEMO ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Interactive Validation Demo</h3>
                <p class="so-card-subtitle">Try submitting the form with empty or invalid values to see validation in action.</p>
            </div>
            <div class="so-card-body">
                        <form id="validationDemoForm" novalidate>
                            <div class="so-form-group" data-validate="required">
                                <label class="so-form-label so-required">Full Name</label>
                                <div class="so-input-wrapper so-show-success-icon so-show-error-icon">
                                    <input type="text" class="so-form-control" placeholder="Enter your full name">
                                    <span class="so-input-icon"><span class="material-icons">person</span></span>
                                </div>
                                <span class="so-form-error"><span class="material-icons">error</span> Name is required</span>
                                <span class="so-form-success"><span class="material-icons">check_circle</span> Looks good!</span>
                            </div>

                            <div class="so-form-group" data-validate="email">
                                <label class="so-form-label so-required">Email Address</label>
                                <div class="so-input-wrapper so-show-success-icon so-show-error-icon">
                                    <input type="email" class="so-form-control" placeholder="name@example.com">
                                    <span class="so-input-icon"><span class="material-icons">email</span></span>
                                </div>
                                <span class="so-form-error"><span class="material-icons">error</span> Please enter a valid email</span>
                                <span class="so-form-success"><span class="material-icons">check_circle</span> Email is valid</span>
                            </div>

                            <div class="so-form-group" data-validate="minlength" data-minlength="8">
                                <label class="so-form-label so-required">Password</label>
                                <div class="so-input-wrapper so-show-success-icon so-show-error-icon">
                                    <input type="password" class="so-form-control" placeholder="Minimum 8 characters">
                                    <span class="so-input-icon"><span class="material-icons">lock</span></span>
                                </div>
                                <span class="so-form-error"><span class="material-icons">error</span> Password must be at least 8 characters</span>
                                <span class="so-form-success"><span class="material-icons">check_circle</span> Password is strong</span>
                            </div>

                            <div class="so-form-group" data-validate="required">
                                <label class="so-form-label so-required">Message</label>
                                <textarea class="so-form-control" rows="3" placeholder="Enter your message"></textarea>
                                <span class="so-form-error"><span class="material-icons">error</span> Message is required</span>
                                <span class="so-form-success"><span class="material-icons">check_circle</span> Message looks good</span>
                            </div>

                            <div class="so-form-group">
                                <label class="so-checkbox">
                                    <input type="checkbox" required>
                                    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                    <span class="so-checkbox-label">I agree to the terms and conditions</span>
                                </label>
                            </div>

                            <button type="submit" class="so-btn so-btn-primary">
                                <span class="material-icons">send</span>
                                Submit Form
                            </button>
                        </form>
                    <div class="so-code-block so-code-block-tabbed">
                        <div class="so-code-header">
                            <div class="so-code-tabs">
                                <button class="so-code-tab so-active" data-so-target="#validation-html">
                                    <span class="material-icons">code</span> HTML
                                </button>
                                <button class="so-code-tab" data-so-target="#validation-js">
                                    <span class="material-icons">javascript</span> JavaScript
                                </button>
                            </div>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <div class="so-code-body">
                            <div class="so-code-pane so-active" id="validation-html">
                                <pre class="so-code-content"><code class="language-html">&lt;form id="validationDemoForm" novalidate&gt;
    &lt;!-- Required Field --&gt;
    &lt;div class="so-form-group" data-validate="required"&gt;
        &lt;label class="so-form-label so-required"&gt;Full Name&lt;/label&gt;
        &lt;div class="so-input-wrapper so-show-success-icon so-show-error-icon"&gt;
            &lt;input type="text" class="so-form-control" placeholder="Enter your full name"&gt;
            &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;person&lt;/span&gt;&lt;/span&gt;
        &lt;/div&gt;
        &lt;span class="so-form-error"&gt;&lt;span class="material-icons"&gt;error&lt;/span&gt; Name is required&lt;/span&gt;
        &lt;span class="so-form-success"&gt;&lt;span class="material-icons"&gt;check_circle&lt;/span&gt; Looks good!&lt;/span&gt;
    &lt;/div&gt;

    &lt;!-- Email Validation --&gt;
    &lt;div class="so-form-group" data-validate="email"&gt;
        &lt;label class="so-form-label so-required"&gt;Email Address&lt;/label&gt;
        &lt;div class="so-input-wrapper so-show-success-icon so-show-error-icon"&gt;
            &lt;input type="email" class="so-form-control" placeholder="name@example.com"&gt;
            &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;email&lt;/span&gt;&lt;/span&gt;
        &lt;/div&gt;
        &lt;span class="so-form-error"&gt;&lt;span class="material-icons"&gt;error&lt;/span&gt; Please enter a valid email&lt;/span&gt;
        &lt;span class="so-form-success"&gt;&lt;span class="material-icons"&gt;check_circle&lt;/span&gt; Email is valid&lt;/span&gt;
    &lt;/div&gt;

    &lt;!-- Minimum Length Validation --&gt;
    &lt;div class="so-form-group" data-validate="minlength" data-minlength="8"&gt;
        &lt;label class="so-form-label so-required"&gt;Password&lt;/label&gt;
        &lt;div class="so-input-wrapper so-show-success-icon so-show-error-icon"&gt;
            &lt;input type="password" class="so-form-control" placeholder="Minimum 8 characters"&gt;
            &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;lock&lt;/span&gt;&lt;/span&gt;
        &lt;/div&gt;
        &lt;span class="so-form-error"&gt;&lt;span class="material-icons"&gt;error&lt;/span&gt; Password must be at least 8 characters&lt;/span&gt;
        &lt;span class="so-form-success"&gt;&lt;span class="material-icons"&gt;check_circle&lt;/span&gt; Password is strong&lt;/span&gt;
    &lt;/div&gt;

    &lt;button type="submit" class="so-btn so-btn-primary"&gt;
        &lt;span class="material-icons"&gt;send&lt;/span&gt;
        Submit Form
    &lt;/button&gt;
&lt;/form&gt;</code></pre>
                            </div>
                            <div class="so-code-pane" id="validation-js">
                                <pre class="so-code-content"><code class="language-javascript">// Form Validation Script
var form = document.getElementById('validationDemoForm');

form.addEventListener('submit', function(e) {
    e.preventDefault();

    var groups = this.querySelectorAll('.so-form-group[data-validate]');
    var isFormValid = true;

    groups.forEach(function(group) {
        var input = group.querySelector('.so-form-control');
        var rule = group.dataset.validate;
        var value = input.value.trim();
        var valid = true;

        // Reset state
        group.classList.remove('has-error', 'has-success', 'so-shake');

        // Validate based on rule
        switch(rule) {
            case 'required':
                valid = value.length > 0;
                break;
            case 'email':
                valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                break;
            case 'minlength':
                var min = parseInt(group.dataset.minlength);
                valid = value.length >= min;
                break;
        }

        // Apply state
        if (valid) {
            group.classList.add('has-success');
        } else {
            group.classList.add('has-error', 'so-shake');
            isFormValid = false;
        }
    });

    if (isFormValid) {
        alert('Form submitted successfully!');
    }
});</code></pre>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <!-- ===================== VALIDATION ICONS ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation Icons</h3>
                <p class="so-card-subtitle">Add <code>so-show-success-icon</code> or <code>so-show-error-icon</code> to <code>so-input-wrapper</code> to show icons automatically based on validation state.</p>
            </div>
            <div class="so-card-body">
                        <div class="so-form-row">
                            <div class="so-form-group has-success">
                                <label class="so-form-label">With Success Icon</label>
                                <div class="so-input-wrapper so-show-success-icon">
                                    <input type="text" class="so-form-control" value="Valid input">
                                </div>
                            </div>
                            <div class="so-form-group has-error">
                                <label class="so-form-label">With Error Icon</label>
                                <div class="so-input-wrapper so-show-error-icon">
                                    <input type="text" class="so-form-control" value="Invalid">
                                </div>
                            </div>
                        </div>
                    <div class="so-code-block">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <pre class="so-code-content"><code class="language-html">&lt;!-- Success with Icon --&gt;
&lt;div class="so-form-group has-success"&gt;
    &lt;label class="so-form-label"&gt;With Success Icon&lt;/label&gt;
    &lt;div class="so-input-wrapper so-show-success-icon"&gt;
        &lt;input type="text" class="so-form-control" value="Valid input"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Error with Icon --&gt;
&lt;div class="so-form-group has-error"&gt;
    &lt;label class="so-form-label"&gt;With Error Icon&lt;/label&gt;
    &lt;div class="so-input-wrapper so-show-error-icon"&gt;
        &lt;input type="text" class="so-form-control" value="Invalid"&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
            </div>
        </div>

    </div>
</main>

<?php require_once '../includes/footer.php'; ?>

<script>
// Shake animation trigger
function triggerShake() {
    var el = document.getElementById('shakeDemo');
    el.classList.remove('so-shake');
    void el.offsetWidth;
    el.classList.add('so-shake');
}

// Character counter for bio
document.getElementById('bioTextarea').addEventListener('input', function() {
    document.getElementById('bioCounter').textContent = this.value.length + '/150';
});

// Character counter for username
document.getElementById('usernameInput').addEventListener('input', function() {
    document.getElementById('usernameCounter').textContent = this.value.length + '/20';
});

// Form validation demo
var form = document.getElementById('validationDemoForm');
form.addEventListener('submit', function(e) {
    e.preventDefault();

    var groups = this.querySelectorAll('.so-form-group[data-validate]');
    var isFormValid = true;

    groups.forEach(function(group) {
        var input = group.querySelector('.so-form-control');
        var rule = group.dataset.validate;
        var value = input.value.trim();
        var valid = true;

        group.classList.remove('has-error', 'has-success', 'so-shake');

        switch(rule) {
            case 'required':
                valid = value.length > 0;
                break;
            case 'email':
                valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                break;
            case 'minlength':
                var min = parseInt(group.dataset.minlength);
                valid = value.length >= min;
                break;
        }

        if (valid) {
            group.classList.add('has-success');
        } else {
            group.classList.add('has-error', 'so-shake');
            isFormValid = false;
        }
    });

    if (isFormValid) {
        alert('Form submitted successfully!');
    }
});
</script>
