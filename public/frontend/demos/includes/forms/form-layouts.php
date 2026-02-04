<div class="so-tab-pane so-fade" id="pane-form-layouts" role="tabpanel">
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Form Layouts</h3>
            <p class="so-card-subtitle">Horizontal, inline, and multi-column form layouts.</p>
        </div>
        <div class="so-card-body">

            <!-- Horizontal Form -->
            <h4 class="so-demo-section-title">Horizontal Form</h4>
            <p class="so-demo-desc">Labels aligned to the right with inputs on the right side.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <form class="so-form-horizontal">
                        <div class="so-form-group">
                            <label class="so-form-label">Full Name</label>
                            <input type="text" class="so-form-control" placeholder="John Doe">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Email</label>
                            <input type="email" class="so-form-control" placeholder="john@example.com">
                            <span class="so-form-hint">We'll never share your email.</span>
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Password</label>
                            <input type="password" class="so-form-control" placeholder="Enter password">
                        </div>
                        <div class="so-form-group so-form-group-check">
                            <label class="so-form-label"></label>
                            <label class="so-checkbox">
                                <input type="checkbox">
                                <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                <span class="so-checkbox-label">Remember me</span>
                            </label>
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label"></label>
                            <button type="button" class="so-btn so-btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;form class="so-form-horizontal"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Full Name&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="John Doe"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Email&lt;/label&gt;
        &lt;input type="email" class="so-form-control" placeholder="john@example.com"&gt;
        &lt;span class="so-form-hint"&gt;We'll never share your email.&lt;/span&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Password&lt;/label&gt;
        &lt;input type="password" class="so-form-control" placeholder="Enter password"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group so-form-group-check"&gt;
        &lt;label class="so-form-label"&gt;&lt;/label&gt;
        &lt;label class="so-checkbox"&gt;
            &lt;input type="checkbox"&gt;
            &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
            &lt;span class="so-checkbox-label"&gt;Remember me&lt;/span&gt;
        &lt;/label&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;&lt;/label&gt;
        &lt;button type="button" class="so-btn so-btn-primary"&gt;Submit&lt;/button&gt;
    &lt;/div&gt;
&lt;/form&gt;</code></pre>
                </div>
            </div>

            <!-- Horizontal Form - Label Width Variants -->
            <h4 class="so-demo-section-title">Horizontal Form - Label Width Variants</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <form class="so-form-horizontal so-form-horizontal-narrow" style="margin-bottom: 2rem;">
                        <p class="so-demo-hint" style="margin-bottom: 1rem;"><strong>Narrow (120px)</strong></p>
                        <div class="so-form-group">
                            <label class="so-form-label">Name</label>
                            <input type="text" class="so-form-control" placeholder="Narrow label width">
                        </div>
                    </form>
                    <form class="so-form-horizontal" style="margin-bottom: 2rem;">
                        <p class="so-demo-hint" style="margin-bottom: 1rem;"><strong>Default (180px)</strong></p>
                        <div class="so-form-group">
                            <label class="so-form-label">Full Name</label>
                            <input type="text" class="so-form-control" placeholder="Default label width">
                        </div>
                    </form>
                    <form class="so-form-horizontal so-form-horizontal-wide">
                        <p class="so-demo-hint" style="margin-bottom: 1rem;"><strong>Wide (240px)</strong></p>
                        <div class="so-form-group">
                            <label class="so-form-label">Company Name</label>
                            <input type="text" class="so-form-control" placeholder="Wide label width">
                        </div>
                    </form>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Narrow Label (120px) --&gt;
&lt;form class="so-form-horizontal so-form-horizontal-narrow"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Name&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="Narrow label width"&gt;
    &lt;/div&gt;
&lt;/form&gt;

&lt;!-- Default Label (180px) --&gt;
&lt;form class="so-form-horizontal"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Full Name&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="Default label width"&gt;
    &lt;/div&gt;
&lt;/form&gt;

&lt;!-- Wide Label (240px) --&gt;
&lt;form class="so-form-horizontal so-form-horizontal-wide"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Company Name&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="Wide label width"&gt;
    &lt;/div&gt;
&lt;/form&gt;</code></pre>
                </div>
            </div>

            <!-- Inline Form -->
            <h4 class="so-demo-section-title">Inline Form</h4>
            <p class="so-demo-desc">All form elements in a single row. Useful for search bars and filters.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <form class="so-form-inline">
                        <div class="so-form-group">
                            <label class="so-form-label">Search</label>
                            <input type="text" class="so-form-control" placeholder="Keyword..." style="width: 200px;">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Category</label>
                            <select class="so-form-control" data-so-select style="width: 150px;">
                                <option>All</option>
                                <option>Products</option>
                                <option>Services</option>
                            </select>
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">&nbsp;</label>
                            <button type="button" class="so-btn so-btn-primary">
                                <span class="material-icons">search</span>
                                Search
                            </button>
                        </div>
                    </form>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;form class="so-form-inline"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Search&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="Keyword..." style="width: 200px;"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Category&lt;/label&gt;
        &lt;select class="so-form-control" data-so-select style="width: 150px;"&gt;
            &lt;option&gt;All&lt;/option&gt;
            &lt;option&gt;Products&lt;/option&gt;
            &lt;option&gt;Services&lt;/option&gt;
        &lt;/select&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;&amp;nbsp;&lt;/label&gt;
        &lt;button type="button" class="so-btn so-btn-primary"&gt;
            &lt;span class="material-icons"&gt;search&lt;/span&gt;
            Search
        &lt;/button&gt;
    &lt;/div&gt;
&lt;/form&gt;</code></pre>
                </div>
            </div>

            <!-- Form Row -->
            <h4 class="so-demo-section-title">Form Row</h4>
            <p class="so-demo-desc">Multiple inputs in a single row with equal widths.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <label class="so-form-label">First Name</label>
                            <input type="text" class="so-form-control" placeholder="John">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Last Name</label>
                            <input type="text" class="so-form-control" placeholder="Doe">
                        </div>
                    </div>
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <label class="so-form-label">City</label>
                            <input type="text" class="so-form-control" placeholder="New York">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">State</label>
                            <input type="text" class="so-form-control" placeholder="NY">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">ZIP</label>
                            <input type="text" class="so-form-control" placeholder="10001">
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Equal Width Columns --&gt;
&lt;div class="so-form-row"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;First Name&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="John"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Last Name&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="Doe"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Three Columns --&gt;
&lt;div class="so-form-row"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;City&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="New York"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;State&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="NY"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;ZIP&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="10001"&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Form Row with Column Sizing -->
            <h4 class="so-demo-section-title">Form Row with Column Sizing</h4>
            <p class="so-demo-desc">Control column widths using <code>so-col-*</code> classes (1-12 grid).</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group so-col-8">
                            <label class="so-form-label">Street Address</label>
                            <input type="text" class="so-form-control" placeholder="123 Main Street">
                        </div>
                        <div class="so-form-group so-col-4">
                            <label class="so-form-label">Apt/Suite</label>
                            <input type="text" class="so-form-control" placeholder="Apt 4B">
                        </div>
                    </div>
                    <div class="so-form-row">
                        <div class="so-form-group so-col-5">
                            <label class="so-form-label">City</label>
                            <input type="text" class="so-form-control" placeholder="New York">
                        </div>
                        <div class="so-form-group so-col-4">
                            <label class="so-form-label">State</label>
                            <select class="so-form-control" data-so-select>
                                <option>Select State</option>
                                <option>New York</option>
                                <option>California</option>
                                <option>Texas</option>
                            </select>
                        </div>
                        <div class="so-form-group so-col-3">
                            <label class="so-form-label">ZIP Code</label>
                            <input type="text" class="so-form-control" placeholder="10001">
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Column Sizing with so-col-* (1-12 grid) --&gt;
&lt;div class="so-form-row"&gt;
    &lt;div class="so-form-group so-col-8"&gt;
        &lt;label class="so-form-label"&gt;Street Address&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="123 Main Street"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group so-col-4"&gt;
        &lt;label class="so-form-label"&gt;Apt/Suite&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="Apt 4B"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class="so-form-row"&gt;
    &lt;div class="so-form-group so-col-5"&gt;
        &lt;label class="so-form-label"&gt;City&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="New York"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group so-col-4"&gt;
        &lt;label class="so-form-label"&gt;State&lt;/label&gt;
        &lt;select class="so-form-control" data-so-select&gt;
            &lt;option&gt;Select State&lt;/option&gt;
            &lt;option&gt;New York&lt;/option&gt;
            &lt;option&gt;California&lt;/option&gt;
            &lt;option&gt;Texas&lt;/option&gt;
        &lt;/select&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group so-col-3"&gt;
        &lt;label class="so-form-label"&gt;ZIP Code&lt;/label&gt;
        &lt;input type="text" class="so-form-control" placeholder="10001"&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Form Row Gap Variants -->
            <h4 class="so-demo-section-title">Form Row Gap Variants</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <p class="so-demo-hint" style="margin-bottom: 0.5rem;"><strong>Small Gap</strong></p>
                    <div class="so-form-row so-form-row-sm">
                        <div class="so-form-group">
                            <input type="text" class="so-form-control" placeholder="Field 1">
                        </div>
                        <div class="so-form-group">
                            <input type="text" class="so-form-control" placeholder="Field 2">
                        </div>
                        <div class="so-form-group">
                            <input type="text" class="so-form-control" placeholder="Field 3">
                        </div>
                    </div>
                    <p class="so-demo-hint" style="margin-bottom: 0.5rem;"><strong>Large Gap</strong></p>
                    <div class="so-form-row so-form-row-lg">
                        <div class="so-form-group">
                            <input type="text" class="so-form-control" placeholder="Field 1">
                        </div>
                        <div class="so-form-group">
                            <input type="text" class="so-form-control" placeholder="Field 2">
                        </div>
                        <div class="so-form-group">
                            <input type="text" class="so-form-control" placeholder="Field 3">
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Small Gap (spacing-2) --&gt;
&lt;div class="so-form-row so-form-row-sm"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="Field 1"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="Field 2"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="Field 3"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Large Gap (spacing-6) --&gt;
&lt;div class="so-form-row so-form-row-lg"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="Field 1"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="Field 2"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;input type="text" class="so-form-control" placeholder="Field 3"&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Form Card -->
            <h4 class="so-demo-section-title">Form Card</h4>
            <p class="so-demo-desc">A styled container for forms with header and footer.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-card" style="max-width: 500px;">
                        <div class="so-form-card-header">
                            <h4 class="so-form-card-title">Account Settings</h4>
                            <p class="so-form-card-subtitle">Update your personal information</p>
                        </div>
                        <div class="so-form-card-body">
                            <div class="so-form-group">
                                <label class="so-form-label">Display Name</label>
                                <input type="text" class="so-form-control" value="John Doe">
                            </div>
                            <div class="so-form-group">
                                <label class="so-form-label">Email</label>
                                <input type="email" class="so-form-control" value="john@example.com">
                            </div>
                            <div class="so-form-group">
                                <label class="so-form-label">Bio</label>
                                <textarea class="so-form-control" rows="3" placeholder="Tell us about yourself..."></textarea>
                            </div>
                        </div>
                        <div class="so-form-card-footer">
                            <button type="button" class="so-btn so-btn-secondary">Cancel</button>
                            <button type="button" class="so-btn so-btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-card"&gt;
    &lt;div class="so-form-card-header"&gt;
        &lt;h4 class="so-form-card-title"&gt;Account Settings&lt;/h4&gt;
        &lt;p class="so-form-card-subtitle"&gt;Update your personal information&lt;/p&gt;
    &lt;/div&gt;
    &lt;div class="so-form-card-body"&gt;
        &lt;div class="so-form-group"&gt;
            &lt;label class="so-form-label"&gt;Display Name&lt;/label&gt;
            &lt;input type="text" class="so-form-control" value="John Doe"&gt;
        &lt;/div&gt;
        &lt;div class="so-form-group"&gt;
            &lt;label class="so-form-label"&gt;Email&lt;/label&gt;
            &lt;input type="email" class="so-form-control" value="john@example.com"&gt;
        &lt;/div&gt;
        &lt;div class="so-form-group"&gt;
            &lt;label class="so-form-label"&gt;Bio&lt;/label&gt;
            &lt;textarea class="so-form-control" rows="3" placeholder="Tell us about yourself..."&gt;&lt;/textarea&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-form-card-footer"&gt;
        &lt;button type="button" class="so-btn so-btn-secondary"&gt;Cancel&lt;/button&gt;
        &lt;button type="button" class="so-btn so-btn-primary"&gt;Save Changes&lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Form Sections -->
            <h4 class="so-demo-section-title">Form Sections</h4>
            <p class="so-demo-desc">Organize long forms into logical sections.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-section">
                        <h5 class="so-form-section-title">Personal Information</h5>
                        <div class="so-form-row">
                            <div class="so-form-group">
                                <label class="so-form-label">First Name</label>
                                <input type="text" class="so-form-control">
                            </div>
                            <div class="so-form-group">
                                <label class="so-form-label">Last Name</label>
                                <input type="text" class="so-form-control">
                            </div>
                        </div>
                    </div>
                    <div class="so-form-section">
                        <h5 class="so-form-section-title">Contact Details</h5>
                        <p class="so-form-section-subtitle">How can we reach you?</p>
                        <div class="so-form-group">
                            <label class="so-form-label">Email</label>
                            <input type="email" class="so-form-control">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Phone</label>
                            <input type="tel" class="so-form-control">
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-section"&gt;
    &lt;h5 class="so-form-section-title"&gt;Personal Information&lt;/h5&gt;
    &lt;div class="so-form-row"&gt;
        &lt;div class="so-form-group"&gt;
            &lt;label class="so-form-label"&gt;First Name&lt;/label&gt;
            &lt;input type="text" class="so-form-control"&gt;
        &lt;/div&gt;
        &lt;div class="so-form-group"&gt;
            &lt;label class="so-form-label"&gt;Last Name&lt;/label&gt;
            &lt;input type="text" class="so-form-control"&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class="so-form-section"&gt;
    &lt;h5 class="so-form-section-title"&gt;Contact Details&lt;/h5&gt;
    &lt;p class="so-form-section-subtitle"&gt;How can we reach you?&lt;/p&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Email&lt;/label&gt;
        &lt;input type="email" class="so-form-control"&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Phone&lt;/label&gt;
        &lt;input type="tel" class="so-form-control"&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Form Divider -->
            <h4 class="so-demo-section-title">Form Divider</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Email</label>
                        <input type="email" class="so-form-control" placeholder="Enter email">
                    </div>
                    <hr class="so-form-divider">
                    <div class="so-form-group">
                        <label class="so-form-label">Password</label>
                        <input type="password" class="so-form-control" placeholder="Enter password">
                    </div>
                    <div class="so-form-divider-text">or continue with</div>
                    <div style="display: flex; gap: 12px; justify-content: center;">
                        <button type="button" class="so-btn so-btn-secondary">
                            <span class="material-icons">g_mobiledata</span> Google
                        </button>
                        <button type="button" class="so-btn so-btn-secondary">
                            <span class="material-icons">facebook</span> Facebook
                        </button>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Email&lt;/label&gt;
    &lt;input type="email" class="so-form-control" placeholder="Enter email"&gt;
&lt;/div&gt;

&lt;!-- Simple Divider Line --&gt;
&lt;hr class="so-form-divider"&gt;

&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Password&lt;/label&gt;
    &lt;input type="password" class="so-form-control" placeholder="Enter password"&gt;
&lt;/div&gt;

&lt;!-- Divider with Text --&gt;
&lt;div class="so-form-divider-text"&gt;or continue with&lt;/div&gt;

&lt;div style="display: flex; gap: 12px; justify-content: center;"&gt;
    &lt;button type="button" class="so-btn so-btn-secondary"&gt;
        &lt;span class="material-icons"&gt;g_mobiledata&lt;/span&gt; Google
    &lt;/button&gt;
    &lt;button type="button" class="so-btn so-btn-secondary"&gt;
        &lt;span class="material-icons"&gt;facebook&lt;/span&gt; Facebook
    &lt;/button&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

        </div>
    </div>
</div>
