<div class="so-tab-pane so-fade" id="pane-input-groups" role="tabpanel">
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Input Groups</h3>
            <p class="so-card-subtitle">Combine inputs with text addons, buttons, or icons.</p>
        </div>
        <div class="so-card-body">

            <!-- Basic Input Group -->
            <h4 class="so-demo-section-title">Text Addons</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Price</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">$</span>
                            <input type="number" class="so-form-control" placeholder="0.00">
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Email</label>
                        <div class="so-input-group">
                            <input type="text" class="so-form-control" placeholder="username">
                            <span class="so-input-addon">@example.com</span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Website</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">https://</span>
                            <input type="text" class="so-form-control" placeholder="www.example.com">
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Addon on the Left --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Price&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;$&lt;/span&gt;
        &lt;input type="number" class="so-form-control" placeholder="0.00"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Addon on the Right --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Email&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="username"&gt;
        &lt;span class="so-input-addon"&gt;@example.com&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Addon on Both Sides --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Website&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;https://&lt;/span&gt;
        &lt;input type="text" class="so-form-control" placeholder="www.example.com"&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Input Group with Button -->
            <h4 class="so-demo-section-title">With Button</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Search</label>
                        <div class="so-input-group">
                            <input type="text" class="so-form-control" placeholder="Search...">
                            <button type="button" class="so-btn so-btn-primary">
                                <span class="material-icons">search</span>
                            </button>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Coupon Code</label>
                        <div class="so-input-group">
                            <input type="text" class="so-form-control" placeholder="Enter coupon code">
                            <button type="button" class="so-btn so-btn-success">Apply</button>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Subscribe</label>
                        <div class="so-input-group">
                            <input type="email" class="so-form-control" placeholder="Your email address">
                            <button type="button" class="so-btn so-btn-primary">
                                <span class="material-icons">send</span>
                                Subscribe
                            </button>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Search with Icon Button --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Search&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="Search..."&gt;
        &lt;button type="button" class="so-btn so-btn-primary"&gt;
            &lt;span class="material-icons"&gt;search&lt;/span&gt;
        &lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Coupon Code --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Coupon Code&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="Enter coupon code"&gt;
        &lt;button type="button" class="so-btn so-btn-success"&gt;Apply&lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Subscribe with Icon and Text --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Subscribe&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;input type="email" class="so-form-control" placeholder="Your email address"&gt;
        &lt;button type="button" class="so-btn so-btn-primary"&gt;
            &lt;span class="material-icons"&gt;send&lt;/span&gt;
            Subscribe
        &lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Multiple Addons -->
            <h4 class="so-demo-section-title">Multiple Addons</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Price Range</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">$</span>
                            <input type="number" class="so-form-control" placeholder="Min">
                            <span class="so-input-addon">to</span>
                            <input type="number" class="so-form-control" placeholder="Max">
                            <span class="so-input-addon">.00</span>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Price Range&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;$&lt;/span&gt;
        &lt;input type="number" class="so-form-control" placeholder="Min"&gt;
        &lt;span class="so-input-addon"&gt;to&lt;/span&gt;
        &lt;input type="number" class="so-form-control" placeholder="Max"&gt;
        &lt;span class="so-input-addon"&gt;.00&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Icon Addons -->
            <h4 class="so-demo-section-title">Icon Addons</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <label class="so-form-label">Phone</label>
                            <div class="so-input-group">
                                <span class="so-input-addon"><span class="material-icons">phone</span></span>
                                <input type="tel" class="so-form-control" placeholder="+1 (555) 123-4567">
                            </div>
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Date</label>
                            <div class="so-input-group">
                                <span class="so-input-addon"><span class="material-icons">calendar_today</span></span>
                                <input type="date" class="so-form-control">
                            </div>
                        </div>
                    </div>
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <label class="so-form-label">Credit Card</label>
                            <div class="so-input-group">
                                <span class="so-input-addon"><span class="material-icons">credit_card</span></span>
                                <input type="text" class="so-form-control" placeholder="1234 5678 9012 3456">
                            </div>
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Location</label>
                            <div class="so-input-group">
                                <span class="so-input-addon"><span class="material-icons">location_on</span></span>
                                <input type="text" class="so-form-control" placeholder="City, State">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Phone with Icon --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Phone&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;&lt;span class="material-icons"&gt;phone&lt;/span&gt;&lt;/span&gt;
        &lt;input type="tel" class="so-form-control" placeholder="+1 (555) 123-4567"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Date with Icon --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Date&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;&lt;span class="material-icons"&gt;calendar_today&lt;/span&gt;&lt;/span&gt;
        &lt;input type="date" class="so-form-control"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Credit Card with Icon --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Credit Card&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;&lt;span class="material-icons"&gt;credit_card&lt;/span&gt;&lt;/span&gt;
        &lt;input type="text" class="so-form-control" placeholder="1234 5678 9012 3456"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Location with Icon --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Location&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;&lt;span class="material-icons"&gt;location_on&lt;/span&gt;&lt;/span&gt;
        &lt;input type="text" class="so-form-control" placeholder="City, State"&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Input with Select -->
            <h4 class="so-demo-section-title">With Select</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Amount</label>
                        <div class="so-input-group">
                            <input type="number" class="so-form-control" placeholder="100">
                            <select class="so-form-control" data-so-select style="max-width: 100px;">
                                <option>USD</option>
                                <option>EUR</option>
                                <option>GBP</option>
                                <option>INR</option>
                            </select>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Phone Number</label>
                        <div class="so-input-group">
                            <select class="so-form-control" data-so-select style="max-width: 120px;">
                                <option>+1 (US)</option>
                                <option>+44 (UK)</option>
                                <option>+91 (IN)</option>
                                <option>+61 (AU)</option>
                            </select>
                            <input type="tel" class="so-form-control" placeholder="Phone number">
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Input with Select on Right --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Amount&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;input type="number" class="so-form-control" placeholder="100"&gt;
        &lt;select class="so-form-control" data-so-select style="max-width: 100px;"&gt;
            &lt;option&gt;USD&lt;/option&gt;
            &lt;option&gt;EUR&lt;/option&gt;
            &lt;option&gt;GBP&lt;/option&gt;
            &lt;option&gt;INR&lt;/option&gt;
        &lt;/select&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Select with Input on Right --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Phone Number&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;select class="so-form-control" data-so-select style="max-width: 120px;"&gt;
            &lt;option&gt;+1 (US)&lt;/option&gt;
            &lt;option&gt;+44 (UK)&lt;/option&gt;
            &lt;option&gt;+91 (IN)&lt;/option&gt;
        &lt;/select&gt;
        &lt;input type="tel" class="so-form-control" placeholder="Phone number"&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Size Variants -->
            <h4 class="so-demo-section-title">Size Variants</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Small</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">$</span>
                            <input type="number" class="so-form-control so-form-control-sm" placeholder="0.00">
                            <button type="button" class="so-btn so-btn-primary so-btn-sm">Go</button>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Default</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">$</span>
                            <input type="number" class="so-form-control" placeholder="0.00">
                            <button type="button" class="so-btn so-btn-primary">Go</button>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Large</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">$</span>
                            <input type="number" class="so-form-control so-form-control-lg" placeholder="0.00">
                            <button type="button" class="so-btn so-btn-primary so-btn-lg">Go</button>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Small Input Group --&gt;
&lt;div class="so-input-group"&gt;
    &lt;span class="so-input-addon"&gt;$&lt;/span&gt;
    &lt;input type="number" class="so-form-control so-form-control-sm" placeholder="0.00"&gt;
    &lt;button type="button" class="so-btn so-btn-primary so-btn-sm"&gt;Go&lt;/button&gt;
&lt;/div&gt;

&lt;!-- Default Input Group --&gt;
&lt;div class="so-input-group"&gt;
    &lt;span class="so-input-addon"&gt;$&lt;/span&gt;
    &lt;input type="number" class="so-form-control" placeholder="0.00"&gt;
    &lt;button type="button" class="so-btn so-btn-primary"&gt;Go&lt;/button&gt;
&lt;/div&gt;

&lt;!-- Large Input Group --&gt;
&lt;div class="so-input-group"&gt;
    &lt;span class="so-input-addon"&gt;$&lt;/span&gt;
    &lt;input type="number" class="so-form-control so-form-control-lg" placeholder="0.00"&gt;
    &lt;button type="button" class="so-btn so-btn-primary so-btn-lg"&gt;Go&lt;/button&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Password Visibility Toggle -->
            <h4 class="so-demo-section-title">Password with Toggle</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Password</label>
                        <div class="so-input-group">
                            <span class="so-input-addon"><span class="material-icons">lock</span></span>
                            <input type="password" class="so-form-control" id="passwordInput" placeholder="Enter password">
                            <button type="button" class="so-btn so-btn-secondary" onclick="togglePassword()">
                                <span class="material-icons" id="passwordIcon">visibility</span>
                            </button>
                        </div>
                    </div>
                    <script>
                    function togglePassword() {
                        var input = document.getElementById('passwordInput');
                        var icon = document.getElementById('passwordIcon');
                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.textContent = 'visibility_off';
                        } else {
                            input.type = 'password';
                            icon.textContent = 'visibility';
                        }
                    }
                    </script>
                </div>
                <div class="so-code-block so-code-block-tabs">
                    <div class="so-code-tabs">
                        <button class="so-code-tab active" data-tab="password-html">HTML</button>
                        <button class="so-code-tab" data-tab="password-js">JavaScript</button>
                    </div>
                    <div class="so-code-panels">
                        <div class="so-code-panel active" id="password-html">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Password&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;&lt;span class="material-icons"&gt;lock&lt;/span&gt;&lt;/span&gt;
        &lt;input type="password" class="so-form-control" id="passwordInput" placeholder="Enter password"&gt;
        &lt;button type="button" class="so-btn so-btn-secondary" onclick="togglePassword()"&gt;
            &lt;span class="material-icons" id="passwordIcon"&gt;visibility&lt;/span&gt;
        &lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        </div>
                        <div class="so-code-panel" id="password-js">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> JavaScript</span>
                                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                            </div>
                            <pre class="so-code-content"><code class="language-javascript">function togglePassword() {
    var input = document.getElementById('passwordInput');
    var icon = document.getElementById('passwordIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copy to Clipboard -->
            <h4 class="so-demo-section-title">Copy to Clipboard</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">API Key</label>
                        <div class="so-input-group">
                            <input type="text" class="so-form-control" id="apiKeyInput" value="sk_live_a1b2c3d4e5f6g7h8i9j0" readonly style="font-family: monospace;">
                            <button type="button" class="so-btn so-btn-secondary" onclick="copyApiKey()">
                                <span class="material-icons">content_copy</span>
                            </button>
                        </div>
                        <span class="so-form-hint" id="copyHint">Click to copy</span>
                    </div>
                    <script>
                    function copyApiKey() {
                        var input = document.getElementById('apiKeyInput');
                        var hint = document.getElementById('copyHint');
                        input.select();
                        document.execCommand('copy');
                        hint.textContent = 'Copied!';
                        hint.style.color = 'var(--so-accent-success)';
                        setTimeout(function() {
                            hint.textContent = 'Click to copy';
                            hint.style.color = '';
                        }, 2000);
                    }
                    </script>
                </div>
                <div class="so-code-block so-code-block-tabs">
                    <div class="so-code-tabs">
                        <button class="so-code-tab active" data-tab="copy-html">HTML</button>
                        <button class="so-code-tab" data-tab="copy-js">JavaScript</button>
                    </div>
                    <div class="so-code-panels">
                        <div class="so-code-panel active" id="copy-html">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;API Key&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;input type="text" class="so-form-control" id="apiKeyInput"
            value="sk_live_a1b2c3d4e5f6g7h8i9j0" readonly
            style="font-family: monospace;"&gt;
        &lt;button type="button" class="so-btn so-btn-secondary" onclick="copyApiKey()"&gt;
            &lt;span class="material-icons"&gt;content_copy&lt;/span&gt;
        &lt;/button&gt;
    &lt;/div&gt;
    &lt;span class="so-form-hint" id="copyHint"&gt;Click to copy&lt;/span&gt;
&lt;/div&gt;</code></pre>
                        </div>
                        <div class="so-code-panel" id="copy-js">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> JavaScript</span>
                                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                            </div>
                            <pre class="so-code-content"><code class="language-javascript">function copyApiKey() {
    var input = document.getElementById('apiKeyInput');
    var hint = document.getElementById('copyHint');

    // Select the text
    input.select();
    input.setSelectionRange(0, 99999); // For mobile devices

    // Copy to clipboard
    navigator.clipboard.writeText(input.value).then(function() {
        // Success feedback
        hint.textContent = 'Copied!';
        hint.style.color = 'var(--so-accent-success)';

        // Reset after 2 seconds
        setTimeout(function() {
            hint.textContent = 'Click to copy';
            hint.style.color = '';
        }, 2000);
    }).catch(function() {
        // Fallback for older browsers
        document.execCommand('copy');
    });
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Group with Checkbox -->
            <h4 class="so-demo-section-title">With Checkbox</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Terms Agreement</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">
                                <input type="checkbox" class="so-checkbox" id="termsCheck">
                            </span>
                            <input type="text" class="so-form-control" value="I agree to the terms and conditions" readonly>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Enable Feature</label>
                        <div class="so-input-group">
                            <input type="text" class="so-form-control" placeholder="Feature description...">
                            <span class="so-input-addon">
                                <input type="checkbox" class="so-checkbox" id="featureCheck" checked>
                                <label for="featureCheck" style="margin-left: 4px; margin-bottom: 0;">Active</label>
                            </span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Multiple Options</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">
                                <input type="checkbox" class="so-checkbox" id="optionA">
                                <label for="optionA" style="margin-left: 4px; margin-bottom: 0;">A</label>
                            </span>
                            <span class="so-input-addon">
                                <input type="checkbox" class="so-checkbox" id="optionB">
                                <label for="optionB" style="margin-left: 4px; margin-bottom: 0;">B</label>
                            </span>
                            <input type="text" class="so-form-control" placeholder="Selected options will appear here">
                            <span class="so-input-addon">
                                <input type="checkbox" class="so-checkbox" id="optionC">
                                <label for="optionC" style="margin-left: 4px; margin-bottom: 0;">C</label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Checkbox on Left --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Terms Agreement&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="checkbox" class="so-checkbox" id="termsCheck"&gt;
        &lt;/span&gt;
        &lt;input type="text" class="so-form-control" value="I agree to the terms and conditions" readonly&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Checkbox on Right with Label --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Enable Feature&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="Feature description..."&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="checkbox" class="so-checkbox" id="featureCheck" checked&gt;
            &lt;label for="featureCheck"&gt;Active&lt;/label&gt;
        &lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Multiple Checkboxes --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Multiple Options&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="checkbox" class="so-checkbox" id="optionA"&gt;
            &lt;label for="optionA"&gt;A&lt;/label&gt;
        &lt;/span&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="checkbox" class="so-checkbox" id="optionB"&gt;
            &lt;label for="optionB"&gt;B&lt;/label&gt;
        &lt;/span&gt;
        &lt;input type="text" class="so-form-control" placeholder="Selected options will appear here"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="checkbox" class="so-checkbox" id="optionC"&gt;
            &lt;label for="optionC"&gt;C&lt;/label&gt;
        &lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Input Group with Radio -->
            <h4 class="so-demo-section-title">With Radio Buttons</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Gender Selection</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">
                                <input type="radio" class="so-radio" name="genderRadio" id="genderMale" value="male">
                                <label for="genderMale" style="margin-left: 4px; margin-bottom: 0;">Male</label>
                            </span>
                            <span class="so-input-addon">
                                <input type="radio" class="so-radio" name="genderRadio" id="genderFemale" value="female">
                                <label for="genderFemale" style="margin-left: 4px; margin-bottom: 0;">Female</label>
                            </span>
                            <input type="text" class="so-form-control" placeholder="Additional details (optional)">
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Payment Method</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">
                                <input type="radio" class="so-radio" name="paymentRadio" id="payCard" value="card" checked>
                                <label for="payCard" style="margin-left: 4px; margin-bottom: 0;"><span class="material-icons" style="font-size: 16px; vertical-align: middle;">credit_card</span></label>
                            </span>
                            <span class="so-input-addon">
                                <input type="radio" class="so-radio" name="paymentRadio" id="payPaypal" value="paypal">
                                <label for="payPaypal" style="margin-left: 4px; margin-bottom: 0;"><span class="material-icons" style="font-size: 16px; vertical-align: middle;">account_balance_wallet</span></label>
                            </span>
                            <span class="so-input-addon">
                                <input type="radio" class="so-radio" name="paymentRadio" id="payBank" value="bank">
                                <label for="payBank" style="margin-left: 4px; margin-bottom: 0;"><span class="material-icons" style="font-size: 16px; vertical-align: middle;">account_balance</span></label>
                            </span>
                            <input type="text" class="so-form-control" placeholder="Enter payment details">
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Priority Level</label>
                        <div class="so-input-group">
                            <input type="text" class="so-form-control" placeholder="Task description">
                            <span class="so-input-addon">
                                <input type="radio" class="so-radio so-radio-success" name="priorityRadio" id="priorityLow" value="low">
                                <label for="priorityLow" style="margin-left: 4px; margin-bottom: 0;">Low</label>
                            </span>
                            <span class="so-input-addon">
                                <input type="radio" class="so-radio so-radio-warning" name="priorityRadio" id="priorityMedium" value="medium" checked>
                                <label for="priorityMedium" style="margin-left: 4px; margin-bottom: 0;">Medium</label>
                            </span>
                            <span class="so-input-addon">
                                <input type="radio" class="so-radio so-radio-danger" name="priorityRadio" id="priorityHigh" value="high">
                                <label for="priorityHigh" style="margin-left: 4px; margin-bottom: 0;">High</label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Radio Buttons on Left --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Gender Selection&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="radio" class="so-radio" name="genderRadio" id="genderMale" value="male"&gt;
            &lt;label for="genderMale"&gt;Male&lt;/label&gt;
        &lt;/span&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="radio" class="so-radio" name="genderRadio" id="genderFemale" value="female"&gt;
            &lt;label for="genderFemale"&gt;Female&lt;/label&gt;
        &lt;/span&gt;
        &lt;input type="text" class="so-form-control" placeholder="Additional details (optional)"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Radio Buttons with Icons --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Payment Method&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="radio" class="so-radio" name="paymentRadio" id="payCard" value="card" checked&gt;
            &lt;label for="payCard"&gt;&lt;span class="material-icons"&gt;credit_card&lt;/span&gt;&lt;/label&gt;
        &lt;/span&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="radio" class="so-radio" name="paymentRadio" id="payPaypal" value="paypal"&gt;
            &lt;label for="payPaypal"&gt;&lt;span class="material-icons"&gt;account_balance_wallet&lt;/span&gt;&lt;/label&gt;
        &lt;/span&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="radio" class="so-radio" name="paymentRadio" id="payBank" value="bank"&gt;
            &lt;label for="payBank"&gt;&lt;span class="material-icons"&gt;account_balance&lt;/span&gt;&lt;/label&gt;
        &lt;/span&gt;
        &lt;input type="text" class="so-form-control" placeholder="Enter payment details"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Colored Radio Buttons on Right --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Priority Level&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="Task description"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="radio" class="so-radio so-radio-success" name="priorityRadio" id="priorityLow" value="low"&gt;
            &lt;label for="priorityLow"&gt;Low&lt;/label&gt;
        &lt;/span&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="radio" class="so-radio so-radio-warning" name="priorityRadio" id="priorityMedium" value="medium" checked&gt;
            &lt;label for="priorityMedium"&gt;Medium&lt;/label&gt;
        &lt;/span&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="radio" class="so-radio so-radio-danger" name="priorityRadio" id="priorityHigh" value="high"&gt;
            &lt;label for="priorityHigh"&gt;High&lt;/label&gt;
        &lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Input Group with Switch -->
            <h4 class="so-demo-section-title">With Switch Toggle</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Feature Toggle</label>
                        <div class="so-input-group">
                            <input type="text" class="so-form-control" value="Dark Mode" readonly>
                            <span class="so-input-addon">
                                <label class="so-switch">
                                    <input type="checkbox" id="darkModeSwitch">
                                    <span class="so-switch-slider"></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Notification Settings</label>
                        <div class="so-input-group">
                            <span class="so-input-addon"><span class="material-icons">notifications</span></span>
                            <input type="text" class="so-form-control" value="Push Notifications" readonly>
                            <span class="so-input-addon">
                                <label class="so-switch so-switch-success">
                                    <input type="checkbox" id="notifSwitch" checked>
                                    <span class="so-switch-slider"></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Auto-Save Draft</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">
                                <label class="so-switch so-switch-sm">
                                    <input type="checkbox" id="autoSaveSwitch" checked>
                                    <span class="so-switch-slider"></span>
                                </label>
                            </span>
                            <input type="text" class="so-form-control" placeholder="Draft content here...">
                            <button type="button" class="so-btn so-btn-primary">
                                <span class="material-icons">save</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Switch on Right --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Feature Toggle&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;input type="text" class="so-form-control" value="Dark Mode" readonly&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;label class="so-switch"&gt;
                &lt;input type="checkbox" id="darkModeSwitch"&gt;
                &lt;span class="so-switch-slider"&gt;&lt;/span&gt;
            &lt;/label&gt;
        &lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Colored Switch with Icon --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Notification Settings&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;&lt;span class="material-icons"&gt;notifications&lt;/span&gt;&lt;/span&gt;
        &lt;input type="text" class="so-form-control" value="Push Notifications" readonly&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;label class="so-switch so-switch-success"&gt;
                &lt;input type="checkbox" id="notifSwitch" checked&gt;
                &lt;span class="so-switch-slider"&gt;&lt;/span&gt;
            &lt;/label&gt;
        &lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Switch on Left with Button --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Auto-Save Draft&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;label class="so-switch so-switch-sm"&gt;
                &lt;input type="checkbox" id="autoSaveSwitch" checked&gt;
                &lt;span class="so-switch-slider"&gt;&lt;/span&gt;
            &lt;/label&gt;
        &lt;/span&gt;
        &lt;input type="text" class="so-form-control" placeholder="Draft content here..."&gt;
        &lt;button type="button" class="so-btn so-btn-primary"&gt;
            &lt;span class="material-icons"&gt;save&lt;/span&gt;
        &lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Multiple Selects -->
            <h4 class="so-demo-section-title">Multiple Selects</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Date Selection</label>
                        <div class="so-input-group">
                            <select class="so-form-control" data-so-select style="max-width: 100px;">
                                <option>Jan</option>
                                <option>Feb</option>
                                <option>Mar</option>
                                <option>Apr</option>
                                <option>May</option>
                                <option>Jun</option>
                                <option>Jul</option>
                                <option>Aug</option>
                                <option>Sep</option>
                                <option>Oct</option>
                                <option>Nov</option>
                                <option>Dec</option>
                            </select>
                            <select class="so-form-control" data-so-select style="max-width: 80px;">
                                <?php for($i = 1; $i <= 31; $i++): ?>
                                <option><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <select class="so-form-control" data-so-select style="max-width: 100px;">
                                <?php for($i = 2026; $i >= 1990; $i--): ?>
                                <option><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Time Selection</label>
                        <div class="so-input-group">
                            <span class="so-input-addon"><span class="material-icons">schedule</span></span>
                            <select class="so-form-control" data-so-select style="max-width: 80px;">
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                <option><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                <?php endfor; ?>
                            </select>
                            <span class="so-input-addon">:</span>
                            <select class="so-form-control" data-so-select style="max-width: 80px;">
                                <?php for($i = 0; $i <= 59; $i += 5): ?>
                                <option><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                <?php endfor; ?>
                            </select>
                            <select class="so-form-control" data-so-select style="max-width: 80px;">
                                <option>AM</option>
                                <option>PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Location Filter <span class="so-badge so-badge-info so-badge-sm">nowrap</span></label>
                        <div class="so-input-group">
                            <select class="so-form-control" data-so-select data-so-nowrap="true" style="max-width: 140px;">
                                <option>Country</option>
                                <option>United States of America</option>
                                <option>United Kingdom</option>
                                <option>Canada</option>
                                <option>India</option>
                                <option>Australia</option>
                            </select>
                            <select class="so-form-control" data-so-select data-so-nowrap="true" style="max-width: 140px;">
                                <option>State/Province</option>
                                <option>California</option>
                                <option>Texas</option>
                                <option>New York</option>
                                <option>North Carolina</option>
                            </select>
                            <select class="so-form-control" data-so-select data-so-nowrap="true" style="max-width: 140px;">
                                <option>City</option>
                                <option>Los Angeles</option>
                                <option>San Francisco</option>
                                <option>Houston</option>
                            </select>
                            <button type="button" class="so-btn so-btn-primary">
                                <span class="material-icons">search</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Date Selection (Month/Day/Year) --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Date Selection&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;select class="so-form-control" data-so-select style="max-width: 100px;"&gt;
            &lt;option&gt;Jan&lt;/option&gt;
            &lt;option&gt;Feb&lt;/option&gt;
            &lt;!-- ... more months --&gt;
        &lt;/select&gt;
        &lt;select class="so-form-control" data-so-select style="max-width: 80px;"&gt;
            &lt;option&gt;1&lt;/option&gt;
            &lt;!-- ... days 1-31 --&gt;
        &lt;/select&gt;
        &lt;select class="so-form-control" data-so-select style="max-width: 100px;"&gt;
            &lt;option&gt;2026&lt;/option&gt;
            &lt;!-- ... years --&gt;
        &lt;/select&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Time Selection with Icon and Separator --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Time Selection&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;&lt;span class="material-icons"&gt;schedule&lt;/span&gt;&lt;/span&gt;
        &lt;select class="so-form-control" data-so-select style="max-width: 80px;"&gt;
            &lt;option&gt;01&lt;/option&gt;
            &lt;!-- ... hours 01-12 --&gt;
        &lt;/select&gt;
        &lt;span class="so-input-addon"&gt;:&lt;/span&gt;
        &lt;select class="so-form-control" data-so-select style="max-width: 80px;"&gt;
            &lt;option&gt;00&lt;/option&gt;
            &lt;!-- ... minutes --&gt;
        &lt;/select&gt;
        &lt;select class="so-form-control" data-so-select style="max-width: 80px;"&gt;
            &lt;option&gt;AM&lt;/option&gt;
            &lt;option&gt;PM&lt;/option&gt;
        &lt;/select&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Multiple Selects with Button + Nowrap (prevents text wrapping in dropdown) --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Location Filter&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;select class="so-form-control" data-so-select data-so-nowrap="true" style="max-width: 140px;"&gt;
            &lt;option&gt;Country&lt;/option&gt;
            &lt;option&gt;United States of America&lt;/option&gt;
            &lt;!-- ... more countries --&gt;
        &lt;/select&gt;
        &lt;select class="so-form-control" data-so-select data-so-nowrap="true" style="max-width: 140px;"&gt;
            &lt;option&gt;State/Province&lt;/option&gt;
            &lt;!-- ... states --&gt;
        &lt;/select&gt;
        &lt;select class="so-form-control" data-so-select data-so-nowrap="true" style="max-width: 140px;"&gt;
            &lt;option&gt;City&lt;/option&gt;
            &lt;!-- ... cities --&gt;
        &lt;/select&gt;
        &lt;button type="button" class="so-btn so-btn-primary"&gt;
            &lt;span class="material-icons"&gt;search&lt;/span&gt;
        &lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Select with Buttons -->
            <h4 class="so-demo-section-title">Select with Buttons</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Category Actions</label>
                        <div class="so-input-group">
                            <select class="so-form-control" data-so-select>
                                <option>Select Category</option>
                                <option>Technology</option>
                                <option>Marketing</option>
                                <option>Finance</option>
                                <option>Operations</option>
                            </select>
                            <button type="button" class="so-btn so-btn-primary">
                                <span class="material-icons">add</span>
                            </button>
                            <button type="button" class="so-btn so-btn-secondary">
                                <span class="material-icons">edit</span>
                            </button>
                            <button type="button" class="so-btn so-btn-danger">
                                <span class="material-icons">delete</span>
                            </button>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Bulk Actions</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">
                                <input type="checkbox" class="so-checkbox" id="selectAll">
                            </span>
                            <select class="so-form-control" data-so-select>
                                <option>Bulk Actions</option>
                                <option>Delete Selected</option>
                                <option>Archive Selected</option>
                                <option>Export Selected</option>
                                <option>Move to...</option>
                            </select>
                            <button type="button" class="so-btn so-btn-primary">Apply</button>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Select with Multiple Buttons --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Category Actions&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;select class="so-form-control" data-so-select&gt;
            &lt;option&gt;Select Category&lt;/option&gt;
            &lt;option&gt;Technology&lt;/option&gt;
            &lt;option&gt;Marketing&lt;/option&gt;
            &lt;option&gt;Finance&lt;/option&gt;
        &lt;/select&gt;
        &lt;button type="button" class="so-btn so-btn-primary"&gt;
            &lt;span class="material-icons"&gt;add&lt;/span&gt;
        &lt;/button&gt;
        &lt;button type="button" class="so-btn so-btn-secondary"&gt;
            &lt;span class="material-icons"&gt;edit&lt;/span&gt;
        &lt;/button&gt;
        &lt;button type="button" class="so-btn so-btn-danger"&gt;
            &lt;span class="material-icons"&gt;delete&lt;/span&gt;
        &lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Checkbox + Select + Button (Bulk Actions) --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Bulk Actions&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="checkbox" class="so-checkbox" id="selectAll"&gt;
        &lt;/span&gt;
        &lt;select class="so-form-control" data-so-select&gt;
            &lt;option&gt;Bulk Actions&lt;/option&gt;
            &lt;option&gt;Delete Selected&lt;/option&gt;
            &lt;option&gt;Archive Selected&lt;/option&gt;
            &lt;option&gt;Export Selected&lt;/option&gt;
        &lt;/select&gt;
        &lt;button type="button" class="so-btn so-btn-primary"&gt;Apply&lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Input with Badges/Labels -->
            <h4 class="so-demo-section-title">With Badges &amp; Labels</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Tagged Input</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">
                                <span class="so-badge so-badge-primary">Required</span>
                            </span>
                            <input type="text" class="so-form-control" placeholder="This field is required">
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Status Input</label>
                        <div class="so-input-group">
                            <input type="text" class="so-form-control" value="Order #12345" readonly>
                            <span class="so-input-addon">
                                <span class="so-badge so-badge-success">Completed</span>
                            </span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Version Info</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">
                                <span class="so-badge so-badge-info">v2.1.0</span>
                            </span>
                            <input type="text" class="so-form-control" value="sixorbit-framework" readonly>
                            <span class="so-input-addon">
                                <span class="so-badge so-badge-warning">Beta</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Badge on Left --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Tagged Input&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;span class="so-badge so-badge-primary"&gt;Required&lt;/span&gt;
        &lt;/span&gt;
        &lt;input type="text" class="so-form-control" placeholder="This field is required"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Badge on Right (Status) --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Status Input&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;input type="text" class="so-form-control" value="Order #12345" readonly&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;span class="so-badge so-badge-success"&gt;Completed&lt;/span&gt;
        &lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Badges on Both Sides --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Version Info&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;span class="so-badge so-badge-info"&gt;v2.1.0&lt;/span&gt;
        &lt;/span&gt;
        &lt;input type="text" class="so-form-control" value="sixorbit-framework" readonly&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;span class="so-badge so-badge-warning"&gt;Beta&lt;/span&gt;
        &lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Textarea with Addons -->
            <h4 class="so-demo-section-title">Textarea with Addons</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Message</label>
                        <div class="so-input-group" style="align-items: flex-start;">
                            <span class="so-input-addon" style="padding-top: 12px;"><span class="material-icons">message</span></span>
                            <textarea class="so-form-control" rows="3" placeholder="Enter your message..."></textarea>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Note with Actions</label>
                        <div class="so-input-group" style="align-items: flex-start;">
                            <textarea class="so-form-control" rows="3" placeholder="Add your note..."></textarea>
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <button type="button" class="so-btn so-btn-secondary so-btn-sm">
                                    <span class="material-icons">format_bold</span>
                                </button>
                                <button type="button" class="so-btn so-btn-secondary so-btn-sm">
                                    <span class="material-icons">format_italic</span>
                                </button>
                                <button type="button" class="so-btn so-btn-secondary so-btn-sm">
                                    <span class="material-icons">attach_file</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Textarea with Icon Addon --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Message&lt;/label&gt;
    &lt;div class="so-input-group" style="align-items: flex-start;"&gt;
        &lt;span class="so-input-addon" style="padding-top: 12px;"&gt;
            &lt;span class="material-icons"&gt;message&lt;/span&gt;
        &lt;/span&gt;
        &lt;textarea class="so-form-control" rows="3" placeholder="Enter your message..."&gt;&lt;/textarea&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Textarea with Button Stack --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Note with Actions&lt;/label&gt;
    &lt;div class="so-input-group" style="align-items: flex-start;"&gt;
        &lt;textarea class="so-form-control" rows="3" placeholder="Add your note..."&gt;&lt;/textarea&gt;
        &lt;div style="display: flex; flex-direction: column; gap: 4px;"&gt;
            &lt;button type="button" class="so-btn so-btn-secondary so-btn-sm"&gt;
                &lt;span class="material-icons"&gt;format_bold&lt;/span&gt;
            &lt;/button&gt;
            &lt;button type="button" class="so-btn so-btn-secondary so-btn-sm"&gt;
                &lt;span class="material-icons"&gt;format_italic&lt;/span&gt;
            &lt;/button&gt;
            &lt;button type="button" class="so-btn so-btn-secondary so-btn-sm"&gt;
                &lt;span class="material-icons"&gt;attach_file&lt;/span&gt;
            &lt;/button&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Combined Elements -->
            <h4 class="so-demo-section-title">Combined Elements</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Advanced Search <span class="so-badge so-badge-info so-badge-sm">nowrap</span></label>
                        <div class="so-input-group">
                            <select class="so-form-control" data-so-select data-so-nowrap="true" style="max-width: 120px;">
                                <option>All Fields</option>
                                <option>Title Only</option>
                                <option>Content Body</option>
                                <option>Author Name</option>
                                <option>Tags & Categories</option>
                            </select>
                            <input type="text" class="so-form-control" placeholder="Search query...">
                            <span class="so-input-addon">
                                <input type="checkbox" class="so-checkbox" id="exactMatch">
                                <label for="exactMatch" style="margin-left: 4px; margin-bottom: 0; white-space: nowrap;">Exact</label>
                            </span>
                            <button type="button" class="so-btn so-btn-primary">
                                <span class="material-icons">search</span>
                            </button>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Product Quantity</label>
                        <div class="so-input-group">
                            <span class="so-input-addon">
                                <span class="so-badge so-badge-primary">SKU-001</span>
                            </span>
                            <button type="button" class="so-btn so-btn-secondary" onclick="decrementQty()">
                                <span class="material-icons">remove</span>
                            </button>
                            <input type="number" class="so-form-control" id="qtyInput" value="1" min="1" style="text-align: center; max-width: 80px;">
                            <button type="button" class="so-btn so-btn-secondary" onclick="incrementQty()">
                                <span class="material-icons">add</span>
                            </button>
                            <select class="so-form-control" data-so-select data-so-nowrap="true" style="max-width: 100px;">
                                <option>Pieces</option>
                                <option>Boxes (12 pcs)</option>
                                <option>Cases (24 pcs)</option>
                                <option>Pallets (100 pcs)</option>
                            </select>
                        </div>
                    </div>
                    <script>
                    function decrementQty() {
                        var input = document.getElementById('qtyInput');
                        if (parseInt(input.value) > 1) {
                            input.value = parseInt(input.value) - 1;
                        }
                    }
                    function incrementQty() {
                        var input = document.getElementById('qtyInput');
                        input.value = parseInt(input.value) + 1;
                    }
                    </script>
                </div>
                <div class="so-code-block so-code-block-tabs">
                    <div class="so-code-tabs">
                        <button class="so-code-tab active" data-tab="combined-html">HTML</button>
                        <button class="so-code-tab" data-tab="combined-js">JavaScript</button>
                    </div>
                    <div class="so-code-panels">
                        <div class="so-code-panel active" id="combined-html">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                            </div>
                            <pre class="so-code-content"><code class="language-html">&lt;!-- Advanced Search: Select with nowrap + Input + Checkbox + Button --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Advanced Search&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;!-- data-so-nowrap prevents text wrapping in dropdown options --&gt;
        &lt;select class="so-form-control" data-so-select data-so-nowrap="true" style="max-width: 120px;"&gt;
            &lt;option&gt;All Fields&lt;/option&gt;
            &lt;option&gt;Title Only&lt;/option&gt;
            &lt;option&gt;Content Body&lt;/option&gt;
            &lt;option&gt;Author Name&lt;/option&gt;
        &lt;/select&gt;
        &lt;input type="text" class="so-form-control" placeholder="Search query..."&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;input type="checkbox" class="so-checkbox" id="exactMatch"&gt;
            &lt;label for="exactMatch"&gt;Exact&lt;/label&gt;
        &lt;/span&gt;
        &lt;button type="button" class="so-btn so-btn-primary"&gt;
            &lt;span class="material-icons"&gt;search&lt;/span&gt;
        &lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Product Quantity: Badge + Buttons + Input + Select --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Product Quantity&lt;/label&gt;
    &lt;div class="so-input-group"&gt;
        &lt;span class="so-input-addon"&gt;
            &lt;span class="so-badge so-badge-primary"&gt;SKU-001&lt;/span&gt;
        &lt;/span&gt;
        &lt;button type="button" class="so-btn so-btn-secondary" onclick="decrementQty()"&gt;
            &lt;span class="material-icons"&gt;remove&lt;/span&gt;
        &lt;/button&gt;
        &lt;input type="number" class="so-form-control" id="qtyInput" value="1" min="1" style="text-align: center; max-width: 80px;"&gt;
        &lt;button type="button" class="so-btn so-btn-secondary" onclick="incrementQty()"&gt;
            &lt;span class="material-icons"&gt;add&lt;/span&gt;
        &lt;/button&gt;
        &lt;select class="so-form-control" data-so-select data-so-nowrap="true" style="max-width: 100px;"&gt;
            &lt;option&gt;Pieces&lt;/option&gt;
            &lt;option&gt;Boxes (12 pcs)&lt;/option&gt;
            &lt;option&gt;Cases (24 pcs)&lt;/option&gt;
            &lt;option&gt;Pallets (100 pcs)&lt;/option&gt;
        &lt;/select&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        </div>
                        <div class="so-code-panel" id="combined-js">
                            <div class="so-code-header">
                                <span class="so-code-label"><span class="material-icons">code</span> JavaScript</span>
                                <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                            </div>
                            <pre class="so-code-content"><code class="language-javascript">function decrementQty() {
    var input = document.getElementById('qtyInput');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function incrementQty() {
    var input = document.getElementById('qtyInput');
    input.value = parseInt(input.value) + 1;
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
