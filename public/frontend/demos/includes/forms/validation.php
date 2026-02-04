<div class="so-tab-pane so-fade" id="pane-validation" role="tabpanel">
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Form Validation</h3>
            <p class="so-card-subtitle">Validation states, error messages, and interactive validation examples.</p>
        </div>
        <div class="so-card-body">

            <!-- Validation States -->
            <h4 class="so-demo-section-title">Validation States</h4>
            <p class="so-demo-desc">Apply <code>has-error</code>, <code>has-success</code>, <code>has-warning</code>, or <code>has-info</code> classes to the form group.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
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

            <!-- Shake Animation -->
            <h4 class="so-demo-section-title">Error Animation</h4>
            <p class="so-demo-desc">Add <code>so-shake</code> class to trigger a shake animation on errors.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group has-error" id="shakeDemo">
                        <label class="so-form-label">Required Field</label>
                        <input type="text" class="so-form-control" placeholder="Leave empty and click button">
                        <span class="so-form-error"><span class="material-icons">error</span> This field is required</span>
                    </div>
                    <button type="button" class="so-btn so-btn-danger" onclick="triggerShake()">
                        <span class="material-icons">error_outline</span>
                        Trigger Shake
                    </button>
                    <script>
                    function triggerShake() {
                        var el = document.getElementById('shakeDemo');
                        el.classList.remove('so-shake');
                        void el.offsetWidth; // Trigger reflow
                        el.classList.add('so-shake');
                    }
                    </script>
                </div>
                <div class="so-code-block so-code-block-tabs">
                    <div class="so-code-tabs">
                        <button class="so-code-tab active" data-tab="shake-html">HTML</button>
                        <button class="so-code-tab" data-tab="shake-js">JavaScript</button>
                    </div>
                    <div class="so-code-panels">
                        <div class="so-code-panel active" id="shake-html">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                            </div>
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
                        <div class="so-code-panel" id="shake-js">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> JavaScript</span>
                                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                            </div>
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

            <!-- Input Hints -->
            <h4 class="so-demo-section-title">Input Hints</h4>
            <p class="so-demo-desc">Use hints to show helper text, character counters, or requirements.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Bio</label>
                        <textarea class="so-form-control" rows="3" maxlength="150" placeholder="Tell us about yourself..." data-char-counter="150" data-counter-target="#bioCounter"></textarea>
                        <div class="so-form-hints">
                            <span class="so-form-hint so-form-hint-left">Keep it brief and friendly</span>
                            <span class="so-form-char-counter so-form-hint-right" id="bioCounter">0/150</span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Username</label>
                        <input type="text" class="so-form-control" maxlength="20" placeholder="Choose a username" data-char-counter="20" data-counter-target="#usernameCounter">
                        <div class="so-form-hints">
                            <span class="so-form-hint so-form-hint-left">Only letters, numbers, and underscores</span>
                            <span class="so-form-char-counter so-form-hint-right" id="usernameCounter">0/20</span>
                        </div>
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
        placeholder="Tell us about yourself..."
        data-char-counter="150"
        data-counter-target="#bioCounter"&gt;&lt;/textarea&gt;
    &lt;div class="so-form-hints"&gt;
        &lt;span class="so-form-hint so-form-hint-left"&gt;Keep it brief and friendly&lt;/span&gt;
        &lt;span class="so-form-char-counter so-form-hint-right" id="bioCounter"&gt;0/150&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Input with Character Counter --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Username&lt;/label&gt;
    &lt;input type="text" class="so-form-control" maxlength="20"
        placeholder="Choose a username"
        data-char-counter="20"
        data-counter-target="#usernameCounter"&gt;
    &lt;div class="so-form-hints"&gt;
        &lt;span class="so-form-hint so-form-hint-left"&gt;Only letters, numbers, and underscores&lt;/span&gt;
        &lt;span class="so-form-char-counter so-form-hint-right" id="usernameCounter"&gt;0/20&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Interactive Validation Demo -->
            <h4 class="so-demo-section-title">Interactive Validation Demo</h4>
            <p class="so-demo-desc">Try submitting the form with empty or invalid values to see validation in action.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
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
                </div>
                <div class="so-code-block so-code-block-tabs">
                    <div class="so-code-tabs">
                        <button class="so-code-tab active" data-tab="validation-html">HTML</button>
                        <button class="so-code-tab" data-tab="validation-js">JavaScript</button>
                    </div>
                    <div class="so-code-panels">
                        <div class="so-code-panel active" id="validation-html">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                            </div>
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

    &lt;!-- Checkbox --&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-checkbox"&gt;
            &lt;input type="checkbox" required&gt;
            &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
            &lt;span class="so-checkbox-label"&gt;I agree to the terms and conditions&lt;/span&gt;
        &lt;/label&gt;
    &lt;/div&gt;

    &lt;button type="submit" class="so-btn so-btn-primary"&gt;
        &lt;span class="material-icons"&gt;send&lt;/span&gt;
        Submit Form
    &lt;/button&gt;
&lt;/form&gt;</code></pre>
                        </div>
                        <div class="so-code-panel" id="validation-js">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> JavaScript</span>
                                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                            </div>
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
});

// Real-time validation on blur
form.querySelectorAll('.so-form-control').forEach(function(input) {
    input.addEventListener('blur', function() {
        var group = this.closest('.so-form-group[data-validate]');
        if (group) {
            // Trigger validation for this field
            var event = new Event('submit');
            // Individual field validation logic here
        }
    });
});</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validation Icons -->
            <h4 class="so-demo-section-title">Validation Icons</h4>
            <p class="so-demo-desc">Add <code>so-show-success-icon</code> or <code>so-show-error-icon</code> to <code>so-input-wrapper</code> to show icons automatically based on validation state.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
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
                </div>
            </div>

        </div>
    </div>
</div>
