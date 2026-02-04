<div class="so-tab-pane so-fade" id="pane-floating-labels" role="tabpanel">
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Floating Labels</h3>
            <p class="so-card-subtitle">Material Design style floating labels with 3 variants: Outlined, Filled, and Standard.</p>
        </div>
        <div class="so-card-body">

            <!-- Material Design Variants -->
            <h4 class="so-demo-section-title">Material Design Variants</h4>
            <p class="so-demo-desc">Three distinct styles following Material Design guidelines.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <p class="so-text-muted so-text-sm so-mb-2">Outlined (Default)</p>
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="text" class="so-form-control" id="floatOutlined" placeholder="Enter text">
                                <label for="floatOutlined">Outlined Label</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <p class="so-text-muted so-text-sm so-mb-2">Filled</p>
                            <div class="so-form-floating so-form-floating-filled">
                                <input type="text" class="so-form-control" id="floatFilled" placeholder="Enter text">
                                <label for="floatFilled">Filled Label</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <p class="so-text-muted so-text-sm so-mb-2">Standard</p>
                            <div class="so-form-floating so-form-floating-standard">
                                <input type="text" class="so-form-control" id="floatStandard" placeholder="Enter text">
                                <label for="floatStandard">Standard Label</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Outlined (Default) --&gt;
&lt;div class="so-form-floating so-form-floating-outlined"&gt;
    &lt;input type="text" class="so-form-control" id="floatOutlined" placeholder="Enter text"&gt;
    &lt;label for="floatOutlined"&gt;Outlined Label&lt;/label&gt;
&lt;/div&gt;

&lt;!-- Filled --&gt;
&lt;div class="so-form-floating so-form-floating-filled"&gt;
    &lt;input type="text" class="so-form-control" id="floatFilled" placeholder="Enter text"&gt;
    &lt;label for="floatFilled"&gt;Filled Label&lt;/label&gt;
&lt;/div&gt;

&lt;!-- Standard --&gt;
&lt;div class="so-form-floating so-form-floating-standard"&gt;
    &lt;input type="text" class="so-form-control" id="floatStandard" placeholder="Enter text"&gt;
    &lt;label for="floatStandard"&gt;Standard Label&lt;/label&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Outlined Form Example -->
            <h4 class="so-demo-section-title">Outlined Form</h4>
            <p class="so-demo-desc">Full border with label overlapping the top border when active.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="text" class="so-form-control" id="outlinedFirst" placeholder="First name">
                                <label for="outlinedFirst">First Name</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="text" class="so-form-control" id="outlinedLast" placeholder="Last name">
                                <label for="outlinedLast">Last Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="email" class="so-form-control" id="outlinedEmail" placeholder="Email">
                                <label for="outlinedEmail">Email Address</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filled Form Example -->
            <h4 class="so-demo-section-title">Filled Form</h4>
            <p class="so-demo-desc">Subtle background with underline emphasis on focus.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-filled">
                                <input type="text" class="so-form-control" id="filledFirst" placeholder="First name">
                                <label for="filledFirst">First Name</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-filled">
                                <input type="text" class="so-form-control" id="filledLast" placeholder="Last name">
                                <label for="filledLast">Last Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-filled">
                            <input type="email" class="so-form-control" id="filledEmail" placeholder="Email">
                            <label for="filledEmail">Email Address</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Standard Form Example -->
            <h4 class="so-demo-section-title">Standard Form</h4>
            <p class="so-demo-desc">Minimal underline style with animated focus indicator.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-standard">
                                <input type="text" class="so-form-control" id="standardFirst" placeholder="First name">
                                <label for="standardFirst">First Name</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-standard">
                                <input type="text" class="so-form-control" id="standardLast" placeholder="Last name">
                                <label for="standardLast">Last Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-standard">
                            <input type="email" class="so-form-control" id="standardEmail" placeholder="Email">
                            <label for="standardEmail">Email Address</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Size Variants -->
            <h4 class="so-demo-section-title">Size Variants</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-sm so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="floatSm" placeholder="Small">
                            <label for="floatSm">Small Floating Label</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="floatDefault" placeholder="Default">
                            <label for="floatDefault">Default Floating Label</label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <div class="so-form-floating so-form-floating-lg so-form-floating-outlined">
                            <input type="text" class="so-form-control" id="floatLg" placeholder="Large">
                            <label for="floatLg">Large Floating Label</label>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-floating so-form-floating-sm so-form-floating-outlined"&gt;...&lt;/div&gt;
&lt;div class="so-form-floating so-form-floating-outlined"&gt;...&lt;/div&gt;
&lt;div class="so-form-floating so-form-floating-lg so-form-floating-outlined"&gt;...&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- With Prefilled Value -->
            <h4 class="so-demo-section-title">Prefilled Value</h4>
            <p class="so-demo-desc">When an input has a value, the label stays floated.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="text" class="so-form-control" id="prefilledOutlined" placeholder="Name" value="John Doe">
                                <label for="prefilledOutlined">Full Name (Outlined)</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-filled">
                                <input type="text" class="so-form-control" id="prefilledFilled" placeholder="Name" value="Jane Smith">
                                <label for="prefilledFilled">Full Name (Filled)</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-standard">
                                <input type="text" class="so-form-control" id="prefilledStandard" placeholder="Name" value="Bob Wilson">
                                <label for="prefilledStandard">Full Name (Standard)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Required Field -->
            <h4 class="so-demo-section-title">Required Field</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-floating so-form-floating-outlined">
                        <input type="text" class="so-form-control" id="floatRequired" placeholder="Required" required>
                        <label for="floatRequired" class="so-required">Company Name</label>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-floating so-form-floating-outlined"&gt;
    &lt;input type="text" class="so-form-control" placeholder="Required" required&gt;
    &lt;label class="so-required"&gt;Company Name&lt;/label&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Validation States -->
            <h4 class="so-demo-section-title">Validation States</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined has-success">
                                <input type="email" class="so-form-control" id="floatSuccess" placeholder="Email" value="valid@email.com">
                                <label for="floatSuccess">Email (Valid)</label>
                            </div>
                            <span class="so-form-success"><span class="material-icons">check_circle</span> Email is valid</span>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined has-error">
                                <input type="email" class="so-form-control" id="floatError" placeholder="Email" value="invalid-email">
                                <label for="floatError">Email (Invalid)</label>
                            </div>
                            <span class="so-form-error"><span class="material-icons">error</span> Please enter a valid email</span>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined has-warning">
                                <input type="text" class="so-form-control" id="floatWarning" placeholder="Username" value="admin">
                                <label for="floatWarning">Username (Warning)</label>
                            </div>
                            <span class="so-form-warning"><span class="material-icons">warning</span> Username is reserved</span>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-floating so-form-floating-outlined has-success"&gt;
    &lt;input type="email" class="so-form-control" value="valid@email.com"&gt;
    &lt;label&gt;Email&lt;/label&gt;
&lt;/div&gt;
&lt;span class="so-form-success"&gt;Email is valid&lt;/span&gt;

&lt;div class="so-form-floating so-form-floating-outlined has-error"&gt;
    &lt;input type="email" class="so-form-control" value="invalid"&gt;
    &lt;label&gt;Email&lt;/label&gt;
&lt;/div&gt;
&lt;span class="so-form-error"&gt;Please enter a valid email&lt;/span&gt;

&lt;div class="so-form-floating so-form-floating-outlined has-warning"&gt;
    &lt;input type="text" class="so-form-control" value="admin"&gt;
    &lt;label&gt;Username&lt;/label&gt;
&lt;/div&gt;
&lt;span class="so-form-warning"&gt;Username is reserved&lt;/span&gt;</code></pre>
                </div>
            </div>

            <!-- Disabled State -->
            <h4 class="so-demo-section-title">Disabled State</h4>
            <p class="so-demo-desc">Disabled inputs cannot be focused or edited. They are skipped in tab order automatically.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined so-disabled">
                                <input type="text" class="so-form-control" id="floatDisabled1" placeholder="Disabled" disabled>
                                <label for="floatDisabled1">Disabled (Empty)</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="text" class="so-form-control" id="floatDisabled2" placeholder="Disabled" value="Prefilled value" disabled>
                                <label for="floatDisabled2">Disabled (With Value)</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-filled">
                                <input type="text" class="so-form-control" id="floatDisabledFilled" placeholder="Disabled" value="Filled disabled" disabled>
                                <label for="floatDisabledFilled">Disabled Filled</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-floating so-form-floating-outlined so-disabled"&gt;
    &lt;input type="text" class="so-form-control" placeholder="Disabled" disabled&gt;
    &lt;label&gt;Disabled (Empty)&lt;/label&gt;
&lt;/div&gt;

&lt;!-- With prefilled value --&gt;
&lt;div class="so-form-floating so-form-floating-outlined"&gt;
    &lt;input type="text" class="so-form-control" value="Prefilled" disabled&gt;
    &lt;label&gt;Disabled (With Value)&lt;/label&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Not Tabbable (Skip in Tab Order) -->
            <h4 class="so-demo-section-title">Not Tabbable (Skip in Tab Order)</h4>
            <p class="so-demo-desc">Use <code>tabindex="-1"</code> to skip an input in the tab order while keeping it clickable. The <code>so-form-floating-notab</code> class provides visual styling.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="text" class="so-form-control" id="floatTab1" placeholder="First">
                                <label for="floatTab1">1. Tabbable (Normal)</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined so-form-floating-notab">
                                <input type="text" class="so-form-control" id="floatNoTab" placeholder="Skipped" tabindex="-1">
                                <label for="floatNoTab">2. Not Tabbable (Skipped)</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="text" class="so-form-control" id="floatTab3" placeholder="Third">
                                <label for="floatTab3">3. Tabbable (Normal)</label>
                            </div>
                        </div>
                    </div>
                    <p class="so-text-muted so-text-sm so-mt-3"><span class="material-icons so-align-middle" style="font-size: 16px;">info</span> Press Tab to navigate - field #2 will be skipped but can still be clicked.</p>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Add tabindex="-1" to skip in tab order --&gt;
&lt;div class="so-form-floating so-form-floating-outlined so-form-floating-notab"&gt;
    &lt;input type="text" class="so-form-control" placeholder="Skipped" tabindex="-1"&gt;
    &lt;label&gt;Not Tabbable&lt;/label&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Read-Only State -->
            <h4 class="so-demo-section-title">Read-Only State</h4>
            <p class="so-demo-desc">Read-only inputs can be focused and selected but not edited. They remain in the tab order unlike disabled inputs.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="text" class="so-form-control" id="floatReadonly1" placeholder="Read-only" value="Cannot edit this" readonly>
                                <label for="floatReadonly1">Read-Only (Outlined)</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-filled">
                                <input type="text" class="so-form-control" id="floatReadonly2" placeholder="Read-only" value="Selectable text" readonly>
                                <label for="floatReadonly2">Read-Only (Filled)</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-standard">
                                <input type="text" class="so-form-control" id="floatReadonly3" placeholder="Read-only" value="Copy this text" readonly>
                                <label for="floatReadonly3">Read-Only (Standard)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Read-only: focusable, selectable, not editable --&gt;
&lt;div class="so-form-floating so-form-floating-outlined"&gt;
    &lt;input type="text" class="so-form-control" value="Cannot edit this" readonly&gt;
    &lt;label&gt;Read-Only&lt;/label&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- With Icons (Adornments) -->
            <h4 class="so-demo-section-title">With Icons (Adornments)</h4>
            <p class="so-demo-desc">Add leading or trailing icons to floating label inputs, similar to MUI InputAdornment.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined so-form-floating-icon-start">
                                <span class="so-input-icon"><span class="material-icons">person</span></span>
                                <input type="text" class="so-form-control" id="floatIconStart" placeholder="Username">
                                <label for="floatIconStart">Username</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined so-form-floating-icon-end">
                                <input type="password" class="so-form-control" id="floatIconEnd" placeholder="Password">
                                <label for="floatIconEnd">Password</label>
                                <button type="button" class="so-input-action" onclick="togglePasswordVisibility(this)">
                                    <span class="material-icons">visibility</span>
                                </button>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined so-form-floating-icon-start so-form-floating-icon-end">
                                <span class="so-input-icon"><span class="material-icons">search</span></span>
                                <input type="text" class="so-form-control" id="floatIconBoth" placeholder="Search">
                                <label for="floatIconBoth">Search</label>
                                <button type="button" class="so-input-action"><span class="material-icons">close</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="so-form-row so-mt-4">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-filled so-form-floating-icon-start">
                                <span class="so-input-icon"><span class="material-icons">email</span></span>
                                <input type="email" class="so-form-control" id="floatFilledIcon" placeholder="Email">
                                <label for="floatFilledIcon">Email Address</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-standard so-form-floating-icon-start">
                                <span class="so-input-icon"><span class="material-icons">phone</span></span>
                                <input type="tel" class="so-form-control" id="floatStandardIcon" placeholder="Phone">
                                <label for="floatStandardIcon">Phone Number</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Leading Icon (Start Adornment) --&gt;
&lt;div class="so-form-floating so-form-floating-outlined so-form-floating-icon-start"&gt;
    &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;person&lt;/span&gt;&lt;/span&gt;
    &lt;input type="text" class="so-form-control" placeholder="Username"&gt;
    &lt;label&gt;Username&lt;/label&gt;
&lt;/div&gt;

&lt;!-- Trailing Action (End Adornment) --&gt;
&lt;div class="so-form-floating so-form-floating-outlined so-form-floating-icon-end"&gt;
    &lt;input type="password" class="so-form-control" placeholder="Password"&gt;
    &lt;label&gt;Password&lt;/label&gt;
    &lt;button type="button" class="so-input-action"&gt;
        &lt;span class="material-icons"&gt;visibility&lt;/span&gt;
    &lt;/button&gt;
&lt;/div&gt;

&lt;!-- Both Icons --&gt;
&lt;div class="so-form-floating so-form-floating-outlined so-form-floating-icon-start so-form-floating-icon-end"&gt;
    &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;search&lt;/span&gt;&lt;/span&gt;
    &lt;input type="text" class="so-form-control" placeholder="Search"&gt;
    &lt;label&gt;Search&lt;/label&gt;
    &lt;button type="button" class="so-input-action"&gt;&lt;span class="material-icons"&gt;close&lt;/span&gt;&lt;/button&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Color Variants -->
            <h4 class="so-demo-section-title">Color Variants</h4>
            <p class="so-demo-desc">Change the focus color of floating labels.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="text" class="so-form-control" id="floatPrimary" placeholder="Primary">
                                <label for="floatPrimary">Primary (Default)</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined so-form-floating-secondary">
                                <input type="text" class="so-form-control" id="floatSecondary" placeholder="Secondary">
                                <label for="floatSecondary">Secondary</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined so-form-floating-info">
                                <input type="text" class="so-form-control" id="floatInfo" placeholder="Info">
                                <label for="floatInfo">Info</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Primary (Default) --&gt;
&lt;div class="so-form-floating so-form-floating-outlined"&gt;...&lt;/div&gt;

&lt;!-- Secondary --&gt;
&lt;div class="so-form-floating so-form-floating-outlined so-form-floating-secondary"&gt;...&lt;/div&gt;

&lt;!-- Info --&gt;
&lt;div class="so-form-floating so-form-floating-outlined so-form-floating-info"&gt;...&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- With Helper Text -->
            <h4 class="so-demo-section-title">With Helper Text</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="password" class="so-form-control" id="floatHelper1" placeholder="Password" minlength="8">
                                <label for="floatHelper1">Password</label>
                            </div>
                            <div class="so-form-hint">
                                <span class="material-icons">info</span>
                                Must be at least 8 characters
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <input type="text" class="so-form-control" id="floatHelper2" placeholder="Bio" maxlength="100" data-char-counter="100" data-counter-target="#bioCounter">
                                <label for="floatHelper2">Bio</label>
                            </div>
                            <div class="so-form-hints">
                                <span class="so-form-hint-left so-form-hint">Short description about yourself</span>
                                <span class="so-form-hint-right so-form-char-counter" id="bioCounter">0/100</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;div class="so-form-floating so-form-floating-outlined"&gt;
        &lt;input type="password" class="so-form-control" placeholder="Password"&gt;
        &lt;label&gt;Password&lt;/label&gt;
    &lt;/div&gt;
    &lt;div class="so-form-hint"&gt;
        &lt;span class="material-icons"&gt;info&lt;/span&gt;
        Must be at least 8 characters
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- With Character Counter --&gt;
&lt;div class="so-form-group"&gt;
    &lt;div class="so-form-floating so-form-floating-outlined"&gt;
        &lt;input type="text" class="so-form-control" maxlength="100"
            data-char-counter="100" data-counter-target="#counter"&gt;
        &lt;label&gt;Bio&lt;/label&gt;
    &lt;/div&gt;
    &lt;div class="so-form-hints"&gt;
        &lt;span class="so-form-hint-left so-form-hint"&gt;Short description&lt;/span&gt;
        &lt;span class="so-form-char-counter" id="counter"&gt;0/100&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Textarea with Floating Label -->
            <h4 class="so-demo-section-title">Textarea with Floating Label</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-outlined">
                                <textarea class="so-form-control" id="floatTextareaOutlined" placeholder="Description" style="height: 100px;"></textarea>
                                <label for="floatTextareaOutlined">Description (Outlined)</label>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <div class="so-form-floating so-form-floating-filled">
                                <textarea class="so-form-control" id="floatTextareaFilled" placeholder="Description" style="height: 100px;"></textarea>
                                <label for="floatTextareaFilled">Description (Filled)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-floating so-form-floating-outlined"&gt;
    &lt;textarea class="so-form-control" placeholder="Description" style="height: 100px;"&gt;&lt;/textarea&gt;
    &lt;label&gt;Description (Outlined)&lt;/label&gt;
&lt;/div&gt;

&lt;div class="so-form-floating so-form-floating-filled"&gt;
    &lt;textarea class="so-form-control" placeholder="Description" style="height: 100px;"&gt;&lt;/textarea&gt;
    &lt;label&gt;Description (Filled)&lt;/label&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

        </div>
    </div>
</div>
