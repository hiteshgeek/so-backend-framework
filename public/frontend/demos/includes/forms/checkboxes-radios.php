<div class="so-tab-pane so-fade" id="pane-checkboxes" role="tabpanel">
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Checkboxes & Radios</h3>
            <p class="so-card-subtitle">Checkbox, radio button, and switch toggle components.</p>
        </div>
        <div class="so-card-body">

            <!-- Checkboxes -->
            <h4 class="so-demo-section-title">Checkboxes</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <label class="so-checkbox">
                        <input type="checkbox">
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Default checkbox</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Checked checkbox</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" disabled>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Disabled checkbox</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" checked disabled>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Disabled checked</span>
                    </label>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Default Checkbox --&gt;
&lt;label class="so-checkbox"&gt;
    &lt;input type="checkbox"&gt;
    &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
    &lt;span class="so-checkbox-label"&gt;Default checkbox&lt;/span&gt;
&lt;/label&gt;

&lt;!-- Checked Checkbox --&gt;
&lt;label class="so-checkbox"&gt;
    &lt;input type="checkbox" checked&gt;
    &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
    &lt;span class="so-checkbox-label"&gt;Checked checkbox&lt;/span&gt;
&lt;/label&gt;

&lt;!-- Disabled Checkbox --&gt;
&lt;label class="so-checkbox"&gt;
    &lt;input type="checkbox" disabled&gt;
    &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
    &lt;span class="so-checkbox-label"&gt;Disabled checkbox&lt;/span&gt;
&lt;/label&gt;

&lt;!-- Disabled Checked Checkbox --&gt;
&lt;label class="so-checkbox"&gt;
    &lt;input type="checkbox" checked disabled&gt;
    &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
    &lt;span class="so-checkbox-label"&gt;Disabled checked&lt;/span&gt;
&lt;/label&gt;</code></pre>
                </div>
            </div>

            <!-- Checkbox Sizes -->
            <h4 class="so-demo-section-title">Checkbox Sizes</h4>
            <div class="so-example-block">
                <div class="so-example-preview" style="display: flex; align-items: center; gap: 24px;">
                    <label class="so-checkbox so-checkbox-sm">
                        <input type="checkbox" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Small</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Default</span>
                    </label>
                    <label class="so-checkbox so-checkbox-lg">
                        <input type="checkbox" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Large</span>
                    </label>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Small Checkbox --&gt;
&lt;label class="so-checkbox so-checkbox-sm"&gt;
    &lt;input type="checkbox" checked&gt;
    &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
    &lt;span class="so-checkbox-label"&gt;Small&lt;/span&gt;
&lt;/label&gt;

&lt;!-- Default Checkbox --&gt;
&lt;label class="so-checkbox"&gt;
    &lt;input type="checkbox" checked&gt;
    &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
    &lt;span class="so-checkbox-label"&gt;Default&lt;/span&gt;
&lt;/label&gt;

&lt;!-- Large Checkbox --&gt;
&lt;label class="so-checkbox so-checkbox-lg"&gt;
    &lt;input type="checkbox" checked&gt;
    &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
    &lt;span class="so-checkbox-label"&gt;Large&lt;/span&gt;
&lt;/label&gt;</code></pre>
                </div>
            </div>

            <!-- Checkbox Colors -->
            <h4 class="so-demo-section-title">Checkbox Colors</h4>
            <div class="so-example-block">
                <div class="so-example-preview" style="display: flex; flex-wrap: wrap; gap: 16px;">
                    <label class="so-checkbox so-checkbox-primary">
                        <input type="checkbox" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Primary</span>
                    </label>
                    <label class="so-checkbox so-checkbox-success">
                        <input type="checkbox" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Success</span>
                    </label>
                    <label class="so-checkbox so-checkbox-danger">
                        <input type="checkbox" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Danger</span>
                    </label>
                    <label class="so-checkbox so-checkbox-warning">
                        <input type="checkbox" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Warning</span>
                    </label>
                    <label class="so-checkbox so-checkbox-info">
                        <input type="checkbox" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Info</span>
                    </label>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;label class="so-checkbox so-checkbox-primary"&gt;...&lt;/label&gt;
&lt;label class="so-checkbox so-checkbox-success"&gt;...&lt;/label&gt;
&lt;label class="so-checkbox so-checkbox-danger"&gt;...&lt;/label&gt;
&lt;label class="so-checkbox so-checkbox-warning"&gt;...&lt;/label&gt;
&lt;label class="so-checkbox so-checkbox-info"&gt;...&lt;/label&gt;</code></pre>
                </div>
            </div>

            <!-- Radio Buttons -->
            <h4 class="so-demo-section-title">Radio Buttons</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <label class="so-radio">
                        <input type="radio" name="radio1" checked>
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Option 1</span>
                    </label>
                    <label class="so-radio">
                        <input type="radio" name="radio1">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Option 2</span>
                    </label>
                    <label class="so-radio">
                        <input type="radio" name="radio1">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Option 3</span>
                    </label>
                    <label class="so-radio">
                        <input type="radio" name="radio1" disabled>
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Disabled</span>
                    </label>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Radio Group (use same name attribute) --&gt;
&lt;label class="so-radio"&gt;
    &lt;input type="radio" name="radio1" checked&gt;
    &lt;span class="so-radio-circle"&gt;&lt;/span&gt;
    &lt;span class="so-radio-label"&gt;Option 1&lt;/span&gt;
&lt;/label&gt;

&lt;label class="so-radio"&gt;
    &lt;input type="radio" name="radio1"&gt;
    &lt;span class="so-radio-circle"&gt;&lt;/span&gt;
    &lt;span class="so-radio-label"&gt;Option 2&lt;/span&gt;
&lt;/label&gt;

&lt;label class="so-radio"&gt;
    &lt;input type="radio" name="radio1"&gt;
    &lt;span class="so-radio-circle"&gt;&lt;/span&gt;
    &lt;span class="so-radio-label"&gt;Option 3&lt;/span&gt;
&lt;/label&gt;

&lt;!-- Disabled Radio --&gt;
&lt;label class="so-radio"&gt;
    &lt;input type="radio" name="radio1" disabled&gt;
    &lt;span class="so-radio-circle"&gt;&lt;/span&gt;
    &lt;span class="so-radio-label"&gt;Disabled&lt;/span&gt;
&lt;/label&gt;</code></pre>
                </div>
            </div>

            <!-- Radio Colors -->
            <h4 class="so-demo-section-title">Radio Colors</h4>
            <div class="so-example-block">
                <div class="so-example-preview" style="display: flex; flex-wrap: wrap; gap: 16px;">
                    <label class="so-radio so-radio-primary">
                        <input type="radio" name="radioColor" checked>
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Primary</span>
                    </label>
                    <label class="so-radio so-radio-success">
                        <input type="radio" name="radioColor">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Success</span>
                    </label>
                    <label class="so-radio so-radio-danger">
                        <input type="radio" name="radioColor">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Danger</span>
                    </label>
                    <label class="so-radio so-radio-warning">
                        <input type="radio" name="radioColor">
                        <span class="so-radio-circle"></span>
                        <span class="so-radio-label">Warning</span>
                    </label>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;label class="so-radio so-radio-primary"&gt;...&lt;/label&gt;
&lt;label class="so-radio so-radio-success"&gt;...&lt;/label&gt;
&lt;label class="so-radio so-radio-danger"&gt;...&lt;/label&gt;
&lt;label class="so-radio so-radio-warning"&gt;...&lt;/label&gt;</code></pre>
                </div>
            </div>

            <!-- Switch Toggle -->
            <h4 class="so-demo-section-title">Switch Toggle</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <label class="so-switch">
                        <input type="checkbox">
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Enable notifications</span>
                    </label>
                    <label class="so-switch">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Dark mode</span>
                    </label>
                    <label class="so-switch">
                        <input type="checkbox" disabled>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Disabled</span>
                    </label>
                    <label class="so-switch">
                        <input type="checkbox" checked disabled>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Disabled on</span>
                    </label>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Default Switch --&gt;
&lt;label class="so-switch"&gt;
    &lt;input type="checkbox"&gt;
    &lt;span class="so-switch-track"&gt;&lt;/span&gt;
    &lt;span class="so-switch-label"&gt;Enable notifications&lt;/span&gt;
&lt;/label&gt;

&lt;!-- Checked Switch --&gt;
&lt;label class="so-switch"&gt;
    &lt;input type="checkbox" checked&gt;
    &lt;span class="so-switch-track"&gt;&lt;/span&gt;
    &lt;span class="so-switch-label"&gt;Dark mode&lt;/span&gt;
&lt;/label&gt;

&lt;!-- Disabled Switch --&gt;
&lt;label class="so-switch"&gt;
    &lt;input type="checkbox" disabled&gt;
    &lt;span class="so-switch-track"&gt;&lt;/span&gt;
    &lt;span class="so-switch-label"&gt;Disabled&lt;/span&gt;
&lt;/label&gt;

&lt;!-- Disabled Checked Switch --&gt;
&lt;label class="so-switch"&gt;
    &lt;input type="checkbox" checked disabled&gt;
    &lt;span class="so-switch-track"&gt;&lt;/span&gt;
    &lt;span class="so-switch-label"&gt;Disabled on&lt;/span&gt;
&lt;/label&gt;</code></pre>
                </div>
            </div>

            <!-- Switch Colors -->
            <h4 class="so-demo-section-title">Switch Colors</h4>
            <div class="so-example-block">
                <div class="so-example-preview" style="display: flex; flex-wrap: wrap; gap: 16px;">
                    <label class="so-switch so-switch-primary">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Primary</span>
                    </label>
                    <label class="so-switch so-switch-success">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Success</span>
                    </label>
                    <label class="so-switch so-switch-danger">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Danger</span>
                    </label>
                    <label class="so-switch so-switch-warning">
                        <input type="checkbox" checked>
                        <span class="so-switch-track"></span>
                        <span class="so-switch-label">Warning</span>
                    </label>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;label class="so-switch so-switch-primary"&gt;...&lt;/label&gt;
&lt;label class="so-switch so-switch-success"&gt;...&lt;/label&gt;
&lt;label class="so-switch so-switch-danger"&gt;...&lt;/label&gt;
&lt;label class="so-switch so-switch-warning"&gt;...&lt;/label&gt;</code></pre>
                </div>
            </div>

            <!-- Inline Checkboxes/Radios -->
            <h4 class="so-demo-section-title">Inline Layout</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Select options:</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 16px;">
                            <label class="so-checkbox">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                <span class="so-checkbox-label">Option A</span>
                            </label>
                            <label class="so-checkbox">
                                <input type="checkbox">
                                <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                <span class="so-checkbox-label">Option B</span>
                            </label>
                            <label class="so-checkbox">
                                <input type="checkbox">
                                <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                <span class="so-checkbox-label">Option C</span>
                            </label>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Choose one:</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 16px;">
                            <label class="so-radio">
                                <input type="radio" name="inlineRadio" checked>
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Yes</span>
                            </label>
                            <label class="so-radio">
                                <input type="radio" name="inlineRadio">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">No</span>
                            </label>
                            <label class="so-radio">
                                <input type="radio" name="inlineRadio">
                                <span class="so-radio-circle"></span>
                                <span class="so-radio-label">Maybe</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Inline Checkboxes --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Select options:&lt;/label&gt;
    &lt;div style="display: flex; flex-wrap: wrap; gap: 16px;"&gt;
        &lt;label class="so-checkbox"&gt;
            &lt;input type="checkbox" checked&gt;
            &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
            &lt;span class="so-checkbox-label"&gt;Option A&lt;/span&gt;
        &lt;/label&gt;
        &lt;label class="so-checkbox"&gt;
            &lt;input type="checkbox"&gt;
            &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
            &lt;span class="so-checkbox-label"&gt;Option B&lt;/span&gt;
        &lt;/label&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Inline Radio Buttons --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Choose one:&lt;/label&gt;
    &lt;div style="display: flex; flex-wrap: wrap; gap: 16px;"&gt;
        &lt;label class="so-radio"&gt;
            &lt;input type="radio" name="inlineRadio" checked&gt;
            &lt;span class="so-radio-circle"&gt;&lt;/span&gt;
            &lt;span class="so-radio-label"&gt;Yes&lt;/span&gt;
        &lt;/label&gt;
        &lt;label class="so-radio"&gt;
            &lt;input type="radio" name="inlineRadio"&gt;
            &lt;span class="so-radio-circle"&gt;&lt;/span&gt;
            &lt;span class="so-radio-label"&gt;No&lt;/span&gt;
        &lt;/label&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Form Group with Checkboxes -->
            <h4 class="so-demo-section-title">In Form Context</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Notification Preferences</label>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label class="so-checkbox">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                <span class="so-checkbox-label">Email notifications</span>
                            </label>
                            <label class="so-checkbox">
                                <input type="checkbox" checked>
                                <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                <span class="so-checkbox-label">SMS notifications</span>
                            </label>
                            <label class="so-checkbox">
                                <input type="checkbox">
                                <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                                <span class="so-checkbox-label">Push notifications</span>
                            </label>
                        </div>
                        <span class="so-form-hint">Choose how you want to receive updates</span>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Notification Preferences&lt;/label&gt;
    &lt;div style="display: flex; flex-direction: column; gap: 8px;"&gt;
        &lt;label class="so-checkbox"&gt;
            &lt;input type="checkbox" checked&gt;
            &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
            &lt;span class="so-checkbox-label"&gt;Email notifications&lt;/span&gt;
        &lt;/label&gt;
        &lt;label class="so-checkbox"&gt;
            &lt;input type="checkbox" checked&gt;
            &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
            &lt;span class="so-checkbox-label"&gt;SMS notifications&lt;/span&gt;
        &lt;/label&gt;
        &lt;label class="so-checkbox"&gt;
            &lt;input type="checkbox"&gt;
            &lt;span class="so-checkbox-box"&gt;&lt;span class="material-icons"&gt;check&lt;/span&gt;&lt;/span&gt;
            &lt;span class="so-checkbox-label"&gt;Push notifications&lt;/span&gt;
        &lt;/label&gt;
    &lt;/div&gt;
    &lt;span class="so-form-hint"&gt;Choose how you want to receive updates&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

        </div>
    </div>
</div>
