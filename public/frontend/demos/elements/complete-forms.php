<?php
/**
 * SixOrbit UI Demo - Complete Form Examples
 */
$pageTitle = 'Complete Form Examples';
$pageDescription = 'Real-world form examples combining various components';

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

        <!-- ===================== LOGIN FORM ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Login Form</h3>
                <p class="so-card-subtitle">A clean login form with social authentication options.</p>
            </div>
            <div class="so-card-body">
                        <div class="so-form-card" style="max-width: 400px; margin: 0 auto;">
                            <div class="so-form-card-header" style="text-align: center;">
                                <h4 class="so-form-card-title">Welcome Back</h4>
                                <p class="so-form-card-subtitle">Sign in to your account</p>
                            </div>
                            <div class="so-form-card-body">
                                <form>
                                    <div class="so-form-group">
                                        <label class="so-form-label">Email</label>
                                        <div class="so-input-wrapper">
                                            <input type="email" class="so-form-control" placeholder="name@example.com">
                                            <span class="so-input-icon"><span class="material-icons">email</span></span>
                                        </div>
                                    </div>
                                    <div class="so-form-group">
                                        <label class="so-form-label">Password</label>
                                        <div class="so-input-wrapper icon-right">
                                            <input type="password" class="so-form-control" placeholder="Enter password">
                                            <span class="so-input-icon"><span class="material-icons">lock</span></span>
                                        </div>
                                    </div>
                                    <div class="so-form-group" style="display: flex; justify-content: space-between; align-items: center;">
                                        <label class="so-checkbox">
                                            <input type="checkbox">
                                            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                            <span class="so-checkbox-label">Remember me</span>
                                        </label>
                                        <a href="#" style="color: var(--so-accent-primary); font-size: 14px;">Forgot password?</a>
                                    </div>
                                    <button type="button" class="so-btn so-btn-primary so-btn-lg" style="width: 100%;">
                                        <span class="material-icons">login</span>
                                        Sign In
                                    </button>
                                </form>
                            </div>
                            <div class="so-form-card-footer" style="justify-content: center; flex-direction: column; gap: 12px;">
                                <div class="so-form-divider-text">or continue with</div>
                                <div style="display: flex; gap: 12px; justify-content: center;">
                                    <button type="button" class="so-btn so-btn-secondary">
                                        <span class="material-icons">g_mobiledata</span>
                                    </button>
                                    <button type="button" class="so-btn so-btn-secondary">
                                        <span class="material-icons">facebook</span>
                                    </button>
                                    <button type="button" class="so-btn so-btn-secondary">
                                        <span class="material-icons">apple</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <div class="so-code-block">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-card" style="max-width: 400px;"&gt;
    &lt;div class="so-form-card-header" style="text-align: center;"&gt;
        &lt;h4 class="so-form-card-title"&gt;Welcome Back&lt;/h4&gt;
        &lt;p class="so-form-card-subtitle"&gt;Sign in to your account&lt;/p&gt;
    &lt;/div&gt;
    &lt;div class="so-form-card-body"&gt;
        &lt;form&gt;
            &lt;div class="so-form-group"&gt;
                &lt;label class="so-form-label"&gt;Email&lt;/label&gt;
                &lt;div class="so-input-wrapper"&gt;
                    &lt;input type="email" class="so-form-control" placeholder="name@example.com"&gt;
                    &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;email&lt;/span&gt;&lt;/span&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class="so-form-group"&gt;
                &lt;label class="so-form-label"&gt;Password&lt;/label&gt;
                &lt;div class="so-input-wrapper icon-right"&gt;
                    &lt;input type="password" class="so-form-control" placeholder="Enter password"&gt;
                    &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;lock&lt;/span&gt;&lt;/span&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class="so-form-group" style="display: flex; justify-content: space-between; align-items: center;"&gt;
                &lt;label class="so-checkbox"&gt;
                    &lt;input type="checkbox"&gt;
                    &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
                    &lt;span class="so-checkbox-label"&gt;Remember me&lt;/span&gt;
                &lt;/label&gt;
                &lt;a href="#"&gt;Forgot password?&lt;/a&gt;
            &lt;/div&gt;
            &lt;button type="button" class="so-btn so-btn-primary so-btn-lg" style="width: 100%;"&gt;
                &lt;span class="material-icons"&gt;login&lt;/span&gt;
                Sign In
            &lt;/button&gt;
        &lt;/form&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
            </div>
        </div>

        <!-- ===================== REGISTRATION FORM ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Registration Form</h3>
                <p class="so-card-subtitle">A user registration form with password requirements.</p>
            </div>
            <div class="so-card-body">
                        <div class="so-form-card" style="max-width: 500px; margin: 0 auto;">
                            <div class="so-form-card-header">
                                <h4 class="so-form-card-title">Create Account</h4>
                                <p class="so-form-card-subtitle">Fill in your details to get started</p>
                            </div>
                            <div class="so-form-card-body">
                                <form>
                                    <div class="so-form-row">
                                        <div class="so-form-group">
                                            <label class="so-form-label so-required">First Name</label>
                                            <input type="text" class="so-form-control" placeholder="John">
                                        </div>
                                        <div class="so-form-group">
                                            <label class="so-form-label so-required">Last Name</label>
                                            <input type="text" class="so-form-control" placeholder="Doe">
                                        </div>
                                    </div>
                                    <div class="so-form-group">
                                        <label class="so-form-label so-required">Email Address</label>
                                        <input type="email" class="so-form-control" placeholder="john.doe@example.com">
                                    </div>
                                    <div class="so-form-group">
                                        <label class="so-form-label so-required">Password</label>
                                        <input type="password" class="so-form-control" placeholder="Create a strong password">
                                        <span class="so-form-hint">At least 8 characters with a number and symbol</span>
                                    </div>
                                    <div class="so-form-group">
                                        <label class="so-form-label so-required">Confirm Password</label>
                                        <input type="password" class="so-form-control" placeholder="Repeat password">
                                    </div>
                                    <div class="so-form-group">
                                        <label class="so-checkbox">
                                            <input type="checkbox">
                                            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                            <span class="so-checkbox-label">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                                        </label>
                                    </div>
                                    <button type="button" class="so-btn so-btn-primary so-btn-lg" style="width: 100%;">
                                        <span class="material-icons">person_add</span>
                                        Create Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    <div class="so-code-block">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-card" style="max-width: 500px;"&gt;
    &lt;div class="so-form-card-header"&gt;
        &lt;h4 class="so-form-card-title"&gt;Create Account&lt;/h4&gt;
        &lt;p class="so-form-card-subtitle"&gt;Fill in your details to get started&lt;/p&gt;
    &lt;/div&gt;
    &lt;div class="so-form-card-body"&gt;
        &lt;form&gt;
            &lt;div class="so-form-row"&gt;
                &lt;div class="so-form-group"&gt;
                    &lt;label class="so-form-label so-required"&gt;First Name&lt;/label&gt;
                    &lt;input type="text" class="so-form-control" placeholder="John"&gt;
                &lt;/div&gt;
                &lt;div class="so-form-group"&gt;
                    &lt;label class="so-form-label so-required"&gt;Last Name&lt;/label&gt;
                    &lt;input type="text" class="so-form-control" placeholder="Doe"&gt;
                &lt;/div&gt;
            &lt;/div&gt;
            &lt;div class="so-form-group"&gt;
                &lt;label class="so-form-label so-required"&gt;Email Address&lt;/label&gt;
                &lt;input type="email" class="so-form-control" placeholder="john.doe@example.com"&gt;
            &lt;/div&gt;
            &lt;div class="so-form-group"&gt;
                &lt;label class="so-form-label so-required"&gt;Password&lt;/label&gt;
                &lt;input type="password" class="so-form-control" placeholder="Create a strong password"&gt;
                &lt;span class="so-form-hint"&gt;At least 8 characters with a number and symbol&lt;/span&gt;
            &lt;/div&gt;
            &lt;div class="so-form-group"&gt;
                &lt;label class="so-form-label so-required"&gt;Confirm Password&lt;/label&gt;
                &lt;input type="password" class="so-form-control" placeholder="Repeat password"&gt;
            &lt;/div&gt;
            &lt;div class="so-form-group"&gt;
                &lt;label class="so-checkbox"&gt;
                    &lt;input type="checkbox"&gt;
                    &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
                    &lt;span class="so-checkbox-label"&gt;I agree to the Terms and Privacy Policy&lt;/span&gt;
                &lt;/label&gt;
            &lt;/div&gt;
            &lt;button type="button" class="so-btn so-btn-primary so-btn-lg" style="width: 100%;"&gt;
                &lt;span class="material-icons"&gt;person_add&lt;/span&gt;
                Create Account
            &lt;/button&gt;
        &lt;/form&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
            </div>
        </div>

        <!-- ===================== CONTACT FORM ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Contact Form</h3>
                <p class="so-card-subtitle">A contact form with file attachments.</p>
            </div>
            <div class="so-card-body">
                        <div class="so-form-card" style="max-width: 600px; margin: 0 auto;">
                            <div class="so-form-card-header">
                                <h4 class="so-form-card-title">Get in Touch</h4>
                                <p class="so-form-card-subtitle">We'd love to hear from you</p>
                            </div>
                            <div class="so-form-card-body">
                                <form>
                                    <div class="so-form-row">
                                        <div class="so-form-group">
                                            <label class="so-form-label so-required">Your Name</label>
                                            <input type="text" class="so-form-control" placeholder="Full name">
                                        </div>
                                        <div class="so-form-group">
                                            <label class="so-form-label so-required">Email</label>
                                            <input type="email" class="so-form-control" placeholder="email@example.com">
                                        </div>
                                    </div>
                                    <div class="so-form-group">
                                        <label class="so-form-label">Subject</label>
                                        <select class="so-form-control" data-so-select>
                                            <option value="">Select a subject</option>
                                            <option>General Inquiry</option>
                                            <option>Technical Support</option>
                                            <option>Sales</option>
                                            <option>Partnership</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div class="so-form-group">
                                        <label class="so-form-label so-required">Message</label>
                                        <textarea class="so-form-control" rows="5" placeholder="How can we help you?" maxlength="500" id="contactMessage"></textarea>
                                        <div class="so-form-hints">
                                            <span class="so-form-hint">Be as detailed as possible</span>
                                            <span class="so-form-char-counter" id="contactCounter">0/500</span>
                                        </div>
                                    </div>
                                    <div class="so-form-group">
                                        <label class="so-form-label">Attachments</label>
                                        <div class="so-form-control-file">
                                            <input type="file" multiple>
                                            <span class="so-form-file-button">
                                                <span class="material-icons">attach_file</span>
                                                Attach Files
                                            </span>
                                            <span class="so-form-file-text">No files attached</span>
                                        </div>
                                        <span class="so-form-hint">Optional: PDF, DOC, or images (max 5MB each)</span>
                                    </div>
                                </form>
                            </div>
                            <div class="so-form-card-footer">
                                <button type="button" class="so-btn so-btn-secondary">Cancel</button>
                                <button type="button" class="so-btn so-btn-primary">
                                    <span class="material-icons">send</span>
                                    Send Message
                                </button>
                            </div>
                        </div>
            </div>
        </div>

        <!-- ===================== SETTINGS FORM ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Settings Form (Horizontal)</h3>
                <p class="so-card-subtitle">A horizontal settings form with sections and switches.</p>
            </div>
            <div class="so-card-body">
                        <div class="so-form-card" style="max-width: 700px; margin: 0 auto;">
                            <div class="so-form-card-header">
                                <h4 class="so-form-card-title">Account Settings</h4>
                                <p class="so-form-card-subtitle">Manage your account preferences</p>
                            </div>
                            <div class="so-form-card-body">
                                <form class="so-form-horizontal">
                                    <div class="so-form-section">
                                        <h5 class="so-form-section-title">Profile Information</h5>
                                        <div class="so-form-group">
                                            <label class="so-form-label">Display Name</label>
                                            <input type="text" class="so-form-control" value="John Doe">
                                        </div>
                                        <div class="so-form-group">
                                            <label class="so-form-label">Email</label>
                                            <div class="so-form-control-plaintext">john.doe@example.com</div>
                                        </div>
                                        <div class="so-form-group">
                                            <label class="so-form-label">Bio</label>
                                            <textarea class="so-form-control" rows="3" placeholder="Tell us about yourself"></textarea>
                                        </div>
                                    </div>

                                    <div class="so-form-section">
                                        <h5 class="so-form-section-title">Notifications</h5>
                                        <div class="so-form-group so-form-group-check">
                                            <label class="so-form-label">Email Alerts</label>
                                            <label class="so-switch">
                                                <input type="checkbox" checked>
                                                <span class="so-switch-track"></span>
                                                <span class="so-switch-label">Receive email notifications</span>
                                            </label>
                                        </div>
                                        <div class="so-form-group so-form-group-check">
                                            <label class="so-form-label">SMS Alerts</label>
                                            <label class="so-switch">
                                                <input type="checkbox">
                                                <span class="so-switch-track"></span>
                                                <span class="so-switch-label">Receive SMS notifications</span>
                                            </label>
                                        </div>
                                        <div class="so-form-group so-form-group-check">
                                            <label class="so-form-label">Marketing</label>
                                            <label class="so-switch">
                                                <input type="checkbox" checked>
                                                <span class="so-switch-track"></span>
                                                <span class="so-switch-label">Receive promotional emails</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="so-form-section">
                                        <h5 class="so-form-section-title">Preferences</h5>
                                        <div class="so-form-group">
                                            <label class="so-form-label">Language</label>
                                            <select class="so-form-control" data-so-select>
                                                <option>English (US)</option>
                                                <option>English (UK)</option>
                                                <option>Spanish</option>
                                                <option>French</option>
                                                <option>German</option>
                                            </select>
                                        </div>
                                        <div class="so-form-group">
                                            <label class="so-form-label">Timezone</label>
                                            <select class="so-form-control" data-so-select>
                                                <option>UTC-08:00 (Pacific Time)</option>
                                                <option>UTC-05:00 (Eastern Time)</option>
                                                <option>UTC+00:00 (GMT)</option>
                                                <option>UTC+05:30 (India)</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="so-form-card-footer">
                                <button type="button" class="so-btn so-btn-secondary">Reset</button>
                                <button type="button" class="so-btn so-btn-primary">
                                    <span class="material-icons">save</span>
                                    Save Changes
                                </button>
                            </div>
                        </div>
            </div>
        </div>

        <!-- ===================== CHECKOUT FORM ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Checkout Form</h3>
                <p class="so-card-subtitle">A payment checkout form with billing and card details.</p>
            </div>
            <div class="so-card-body">
                        <div class="so-form-card" style="max-width: 600px; margin: 0 auto;">
                            <div class="so-form-card-header">
                                <h4 class="so-form-card-title">Payment Details</h4>
                                <p class="so-form-card-subtitle">Complete your purchase</p>
                            </div>
                            <div class="so-form-card-body">
                                <form>
                                    <div class="so-form-section">
                                        <h5 class="so-form-section-title">Billing Address</h5>
                                        <div class="so-form-group">
                                            <label class="so-form-label so-required">Full Name</label>
                                            <input type="text" class="so-form-control" placeholder="Name on card">
                                        </div>
                                        <div class="so-form-group">
                                            <label class="so-form-label so-required">Address</label>
                                            <input type="text" class="so-form-control" placeholder="Street address">
                                        </div>
                                        <div class="so-form-row">
                                            <div class="so-form-group so-col-5">
                                                <label class="so-form-label so-required">City</label>
                                                <input type="text" class="so-form-control" placeholder="City">
                                            </div>
                                            <div class="so-form-group so-col-4">
                                                <label class="so-form-label so-required">State</label>
                                                <select class="so-form-control" data-so-select>
                                                    <option value="">Select</option>
                                                    <option>California</option>
                                                    <option>New York</option>
                                                    <option>Texas</option>
                                                </select>
                                            </div>
                                            <div class="so-form-group so-col-3">
                                                <label class="so-form-label so-required">ZIP</label>
                                                <input type="text" class="so-form-control" placeholder="12345">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="so-form-section">
                                        <h5 class="so-form-section-title">Card Information</h5>
                                        <div class="so-form-group">
                                            <label class="so-form-label so-required">Card Number</label>
                                            <div class="so-input-group">
                                                <span class="so-input-addon"><span class="material-icons">credit_card</span></span>
                                                <input type="text" class="so-form-control" placeholder="1234 5678 9012 3456">
                                            </div>
                                        </div>
                                        <div class="so-form-row">
                                            <div class="so-form-group so-col-6">
                                                <label class="so-form-label so-required">Expiry Date</label>
                                                <div class="so-input-group">
                                                    <input type="text" class="so-form-control" placeholder="MM" style="text-align: center;" maxlength="2">
                                                    <span class="so-input-addon">/</span>
                                                    <input type="text" class="so-form-control" placeholder="YY" style="text-align: center;" maxlength="2">
                                                </div>
                                            </div>
                                            <div class="so-form-group so-col-6">
                                                <label class="so-form-label so-required">CVV</label>
                                                <div class="so-input-group">
                                                    <input type="password" class="so-form-control" placeholder="123" maxlength="4">
                                                    <span class="so-input-addon"><span class="material-icons">help_outline</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="so-form-group">
                                        <label class="so-checkbox">
                                            <input type="checkbox" checked>
                                            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                            <span class="so-checkbox-label">Save card for future purchases</span>
                                        </label>
                                    </div>
                                </form>
                            </div>
                            <div class="so-form-card-footer" style="flex-direction: column; gap: 12px;">
                                <div style="display: flex; justify-content: space-between; width: 100%; font-size: 18px; font-weight: 500;">
                                    <span>Total:</span>
                                    <span>$99.00</span>
                                </div>
                                <button type="button" class="so-btn so-btn-success so-btn-lg" style="width: 100%;">
                                    <span class="material-icons">lock</span>
                                    Pay $99.00
                                </button>
                                <p style="text-align: center; font-size: 12px; color: var(--so-text-muted); margin: 0;">
                                    <span class="material-icons" style="font-size: 14px; vertical-align: middle;">verified_user</span>
                                    Your payment is secure and encrypted
                                </p>
                            </div>
                        </div>
            </div>
        </div>

    </div>
</main>

<script>
// Character counter for contact form
document.getElementById('contactMessage').addEventListener('input', function() {
    document.getElementById('contactCounter').textContent = this.value.length + '/500';
});

// File input display
document.querySelectorAll('.so-form-control-file input[type="file"]').forEach(input => {
    input.addEventListener('change', function() {
        const fileText = this.closest('.so-form-control-file').querySelector('.so-form-file-text');
        if (this.files.length > 0) {
            const fileNames = Array.from(this.files).map(f => f.name).join(', ');
            fileText.textContent = fileNames;
            fileText.classList.add('has-file');
        } else {
            fileText.textContent = 'No files attached';
            fileText.classList.remove('has-file');
        }
    });
});
</script>

<?php require_once '../includes/footer.php'; ?>
