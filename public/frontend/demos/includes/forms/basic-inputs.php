<div class="so-tab-pane so-fade so-active" id="pane-basic-inputs" role="tabpanel">
    <div class="so-card">
        <div class="so-card-header">
            <h3 class="so-card-title">Basic Inputs</h3>
            <p class="so-card-subtitle">Text, email, password, number, and textarea inputs with various states and sizes.</p>
        </div>
        <div class="so-card-body">

            <!-- Default Inputs -->
            <h4 class="so-demo-section-title">Default Input</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label" for="input-default">Default Input</label>
                        <input type="text" class="so-form-control" id="input-default" placeholder="Enter text...">
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label" for="input-default"&gt;Default Input&lt;/label&gt;
    &lt;input type="text" class="so-form-control" id="input-default" placeholder="Enter text..."&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Input Types -->
            <h4 class="so-demo-section-title">Input Types</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <label class="so-form-label">Text</label>
                            <input type="text" class="so-form-control" placeholder="Text input">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Email</label>
                            <input type="email" class="so-form-control" placeholder="email@example.com">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Password</label>
                            <input type="password" class="so-form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <label class="so-form-label">Number</label>
                            <input type="number" class="so-form-control" placeholder="0">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Tel</label>
                            <input type="tel" class="so-form-control" placeholder="+1 (555) 123-4567">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">URL</label>
                            <input type="url" class="so-form-control" placeholder="https://example.com">
                        </div>
                    </div>
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <label class="so-form-label">Date</label>
                            <input type="date" class="so-form-control">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Time</label>
                            <input type="time" class="so-form-control">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Search</label>
                            <input type="search" class="so-form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Sizes -->
            <h4 class="so-demo-section-title">Input Sizes</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Small</label>
                        <input type="text" class="so-form-control so-form-control-sm" placeholder="Small input">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Default</label>
                        <input type="text" class="so-form-control" placeholder="Default input">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Large</label>
                        <input type="text" class="so-form-control so-form-control-lg" placeholder="Large input">
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;input type="text" class="so-form-control so-form-control-sm" placeholder="Small"&gt;
&lt;input type="text" class="so-form-control" placeholder="Default"&gt;
&lt;input type="text" class="so-form-control so-form-control-lg" placeholder="Large"&gt;</code></pre>
                </div>
            </div>

            <!-- Input States -->
            <h4 class="so-demo-section-title">Input States</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <label class="so-form-label">Normal</label>
                            <input type="text" class="so-form-control" value="Normal input">
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Disabled</label>
                            <input type="text" class="so-form-control" value="Disabled input" disabled>
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Readonly</label>
                            <input type="text" class="so-form-control" value="Readonly input" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Textarea -->
            <h4 class="so-demo-section-title">Textarea</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label">Default Textarea</label>
                        <textarea class="so-form-control" rows="3" placeholder="Enter your message..."></textarea>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Textarea with Character Counter</label>
                        <textarea class="so-form-control" rows="3" maxlength="200" placeholder="Limited to 200 characters..." data-char-counter="200" data-counter-target="#charCounter1"></textarea>
                        <div class="so-form-hints">
                            <span class="so-form-hint">Write a short description</span>
                            <span class="so-form-char-counter" id="charCounter1">0/200</span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Autosize Textarea</label>
                        <textarea class="so-form-control so-form-control-autosize" placeholder="This textarea auto-expands as you type..." data-autosize="true"></textarea>
                        <span class="so-form-hint">Automatically adjusts height based on content</span>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;!-- Default Textarea --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Default Textarea&lt;/label&gt;
    &lt;textarea class="so-form-control" rows="3" placeholder="Enter your message..."&gt;&lt;/textarea&gt;
&lt;/div&gt;

&lt;!-- Textarea with Character Counter --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Textarea with Character Counter&lt;/label&gt;
    &lt;textarea class="so-form-control" rows="3" maxlength="200"
        placeholder="Limited to 200 characters..."
        data-char-counter="200"
        data-counter-target="#charCounter"&gt;&lt;/textarea&gt;
    &lt;div class="so-form-hints"&gt;
        &lt;span class="so-form-hint"&gt;Write a short description&lt;/span&gt;
        &lt;span class="so-form-char-counter" id="charCounter"&gt;0/200&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;!-- Autosize Textarea --&gt;
&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Autosize Textarea&lt;/label&gt;
    &lt;textarea class="so-form-control so-form-control-autosize"
        placeholder="This textarea auto-expands as you type..."
        data-autosize="true"&gt;&lt;/textarea&gt;
    &lt;span class="so-form-hint"&gt;Automatically adjusts height based on content&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Required Field -->
            <h4 class="so-demo-section-title">Required Field</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-group">
                        <label class="so-form-label so-required">Required Field</label>
                        <input type="text" class="so-form-control" placeholder="This field is required" required>
                        <span class="so-form-hint">Fields marked with * are required</span>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label so-required"&gt;Required Field&lt;/label&gt;
    &lt;input type="text" class="so-form-control" required&gt;
    &lt;span class="so-form-hint"&gt;Fields marked with * are required&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Input with Icon -->
            <h4 class="so-demo-section-title">Input with Icon</h4>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <label class="so-form-label">Icon Left</label>
                            <div class="so-input-wrapper">
                                <input type="text" class="so-form-control" placeholder="Search...">
                                <span class="so-input-icon"><span class="material-icons">search</span></span>
                            </div>
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">Icon Right</label>
                            <div class="so-input-wrapper icon-right">
                                <input type="email" class="so-form-control" placeholder="Email address">
                                <span class="so-input-icon"><span class="material-icons">email</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-input-wrapper"&gt;
    &lt;input type="text" class="so-form-control" placeholder="Search..."&gt;
    &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;search&lt;/span&gt;&lt;/span&gt;
&lt;/div&gt;

&lt;div class="so-input-wrapper icon-right"&gt;
    &lt;input type="email" class="so-form-control" placeholder="Email"&gt;
    &lt;span class="so-input-icon"&gt;&lt;span class="material-icons"&gt;email&lt;/span&gt;&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>

            <!-- Plaintext Readonly -->
            <h4 class="so-demo-section-title">Plaintext Readonly</h4>
            <p class="so-demo-desc">Display form values as plain text without input styling.</p>
            <div class="so-example-block">
                <div class="so-example-preview">
                    <div class="so-form-row">
                        <div class="so-form-group">
                            <label class="so-form-label">Email</label>
                            <div class="so-form-control-plaintext">john.doe@example.com</div>
                        </div>
                        <div class="so-form-group">
                            <label class="so-form-label">With Underline</label>
                            <div class="so-form-control-plaintext so-form-control-plaintext-underline">$1,234.56</div>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                    <div class="so-code-header">
                        <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                        <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                    </div>
                    <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-control-plaintext"&gt;john.doe@example.com&lt;/div&gt;
&lt;div class="so-form-control-plaintext so-form-control-plaintext-underline"&gt;$1,234.56&lt;/div&gt;</code></pre>
                </div>
            </div>

        </div>
    </div>
</div>
