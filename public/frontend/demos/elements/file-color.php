<?php
/**
 * SixOrbit UI Demo - File & Color Inputs
 */
$pageTitle = 'File & Color Inputs';
$pageDescription = 'Styled file upload controls, drag-and-drop zones, and color pickers';

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

        <!-- ===================== FILE INPUT ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">File Input</h3>
                <p class="so-card-subtitle">A styled file input with browse button and filename display.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label">Upload Document</label>
                    <div class="so-form-control-file">
                        <input type="file" id="fileInput1">
                        <span class="so-form-file-button">
                            <span class="material-icons">upload_file</span>
                            Browse
                        </span>
                        <span class="so-form-file-text">No file chosen</span>
                    </div>
                </div>
                <div class="so-code-block so-code-block-tabbed">
                        <div class="so-code-header">
                            <div class="so-code-tabs">
                                <button class="so-code-tab so-active" data-so-target="#file-input-html">
                                    <span class="material-icons">code</span> HTML
                                </button>
                                <button class="so-code-tab" data-so-target="#file-input-js">
                                    <span class="material-icons">javascript</span> JavaScript
                                </button>
                            </div>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <div class="so-code-body">
                            <div class="so-code-pane so-active" id="file-input-html">
                                <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Upload Document&lt;/label&gt;
    &lt;div class="so-form-control-file"&gt;
        &lt;input type="file" id="fileInput"&gt;
        &lt;span class="so-form-file-button"&gt;
            &lt;span class="material-icons"&gt;upload_file&lt;/span&gt;
            Browse
        &lt;/span&gt;
        &lt;span class="so-form-file-text"&gt;No file chosen&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                            </div>
                            <div class="so-code-pane" id="file-input-js">
                                <pre class="so-code-content"><code class="language-javascript">// Update filename display when file is selected
document.querySelectorAll('.so-form-control-file input[type="file"]').forEach(input => {
    input.addEventListener('change', function() {
        const fileText = this.closest('.so-form-control-file').querySelector('.so-form-file-text');
        if (this.files.length > 0) {
            const fileNames = Array.from(this.files).map(f => f.name).join(', ');
            fileText.textContent = fileNames;
            fileText.classList.add('has-file');
        } else {
            fileText.textContent = 'No file chosen';
            fileText.classList.remove('has-file');
        }
    });
});</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- ===================== MULTIPLE FILES ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Multiple Files</h3>
                <p class="so-card-subtitle">Allow users to select multiple files at once.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label">Upload Images</label>
                    <div class="so-form-control-file">
                        <input type="file" multiple accept="image/*">
                        <span class="so-form-file-button">
                            <span class="material-icons">photo_library</span>
                            Choose Files
                        </span>
                        <span class="so-form-file-text">No files chosen</span>
                    </div>
                    <span class="so-form-hint">You can select multiple images</span>
                </div>
                <div class="so-code-block">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Upload Images&lt;/label&gt;
    &lt;div class="so-form-control-file"&gt;
        &lt;input type="file" multiple accept="image/*"&gt;
        &lt;span class="so-form-file-button"&gt;
            &lt;span class="material-icons"&gt;photo_library&lt;/span&gt;
            Choose Files
        &lt;/span&gt;
        &lt;span class="so-form-file-text"&gt;No files chosen&lt;/span&gt;
    &lt;/div&gt;
    &lt;span class="so-form-hint"&gt;You can select multiple images&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== FILE INPUT SIZES ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">File Input Sizes</h3>
                <p class="so-card-subtitle">Small, default, and large file input variants.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label">Small</label>
                    <div class="so-form-control-file so-form-control-file-sm">
                        <input type="file">
                        <span class="so-form-file-button">
                            <span class="material-icons">upload</span>
                            Browse
                        </span>
                        <span class="so-form-file-text">No file chosen</span>
                    </div>
                </div>
                <div class="so-form-group">
                    <label class="so-form-label">Default</label>
                    <div class="so-form-control-file">
                        <input type="file">
                        <span class="so-form-file-button">
                            <span class="material-icons">upload</span>
                            Browse
                        </span>
                        <span class="so-form-file-text">No file chosen</span>
                    </div>
                </div>
                <div class="so-form-group">
                    <label class="so-form-label">Large</label>
                    <div class="so-form-control-file so-form-control-file-lg">
                        <input type="file">
                        <span class="so-form-file-button">
                            <span class="material-icons">upload</span>
                            Browse
                        </span>
                        <span class="so-form-file-text">No file chosen</span>
                    </div>
                </div>
                <div class="so-code-block">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <pre class="so-code-content"><code class="language-html">&lt;!-- Small --&gt;
&lt;div class="so-form-control-file so-form-control-file-sm"&gt;
    &lt;input type="file"&gt;
    &lt;span class="so-form-file-button"&gt;
        &lt;span class="material-icons"&gt;upload&lt;/span&gt;
        Browse
    &lt;/span&gt;
    &lt;span class="so-form-file-text"&gt;No file chosen&lt;/span&gt;
&lt;/div&gt;

&lt;!-- Default --&gt;
&lt;div class="so-form-control-file"&gt;
    &lt;input type="file"&gt;
    &lt;span class="so-form-file-button"&gt;
        &lt;span class="material-icons"&gt;upload&lt;/span&gt;
        Browse
    &lt;/span&gt;
    &lt;span class="so-form-file-text"&gt;No file chosen&lt;/span&gt;
&lt;/div&gt;

&lt;!-- Large --&gt;
&lt;div class="so-form-control-file so-form-control-file-lg"&gt;
    &lt;input type="file"&gt;
    &lt;span class="so-form-file-button"&gt;
        &lt;span class="material-icons"&gt;upload&lt;/span&gt;
        Browse
    &lt;/span&gt;
    &lt;span class="so-form-file-text"&gt;No file chosen&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== DROPZONE ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Drag & Drop Zone</h3>
                <p class="so-card-subtitle">A large dropzone area for drag-and-drop file uploads.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label">Upload Files</label>
                    <div class="so-form-file-dropzone" id="dropzone1">
                        <input type="file" multiple>
                        <div class="so-form-file-dropzone-icon">
                            <span class="material-icons">cloud_upload</span>
                        </div>
                        <div class="so-form-file-dropzone-text">
                            Drag & drop files here, or <span>click to browse</span>
                        </div>
                        <div class="so-form-file-dropzone-hint">
                            Supports: PDF, DOC, DOCX, XLS, XLSX (max 10MB)
                        </div>
                    </div>
                </div>
                <div class="so-code-block so-code-block-tabbed">
                        <div class="so-code-header">
                            <div class="so-code-tabs">
                                <button class="so-code-tab so-active" data-so-target="#dropzone-html">
                                    <span class="material-icons">code</span> HTML
                                </button>
                                <button class="so-code-tab" data-so-target="#dropzone-js">
                                    <span class="material-icons">javascript</span> JavaScript
                                </button>
                            </div>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <div class="so-code-body">
                            <div class="so-code-pane so-active" id="dropzone-html">
                                <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Upload Files&lt;/label&gt;
    &lt;div class="so-form-file-dropzone" id="dropzone1"&gt;
        &lt;input type="file" multiple&gt;
        &lt;div class="so-form-file-dropzone-icon"&gt;
            &lt;span class="material-icons"&gt;cloud_upload&lt;/span&gt;
        &lt;/div&gt;
        &lt;div class="so-form-file-dropzone-text"&gt;
            Drag &amp; drop files here, or &lt;span&gt;click to browse&lt;/span&gt;
        &lt;/div&gt;
        &lt;div class="so-form-file-dropzone-hint"&gt;
            Supports: PDF, DOC, DOCX, XLS, XLSX (max 10MB)
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                            </div>
                            <div class="so-code-pane" id="dropzone-js">
                                <pre class="so-code-content"><code class="language-javascript">// Dropzone drag and drop functionality
document.querySelectorAll('.so-form-file-dropzone').forEach(dropzone => {
    const input = dropzone.querySelector('input[type="file"]');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight dropzone when dragging over
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.add('so-dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.remove('so-dragover');
        }, false);
    });

    // Handle dropped files
    dropzone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        input.files = files;
        handleFiles(files, dropzone);
    }, false);

    // Handle file input change
    input.addEventListener('change', function() {
        handleFiles(this.files, dropzone);
    });
});

function handleFiles(files, dropzone) {
    if (files.length > 0) {
        const fileNames = Array.from(files).map(f => f.name).join(', ');
        const textEl = dropzone.querySelector('.so-form-file-dropzone-text');
        textEl.innerHTML = `&lt;strong&gt;${files.length} file(s) selected:&lt;/strong&gt; ${fileNames}`;
    }
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- ===================== IMAGE DROPZONE ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Image Dropzone</h3>
                <p class="so-card-subtitle">Compact dropzone variant for image uploads.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label">Profile Photo</label>
                    <div class="so-form-file-dropzone" style="padding: 2rem;">
                        <input type="file" accept="image/*">
                        <div class="so-form-file-dropzone-icon">
                            <span class="material-icons">add_photo_alternate</span>
                        </div>
                        <div class="so-form-file-dropzone-text">
                            <span>Click to upload</span> or drag and drop
                        </div>
                        <div class="so-form-file-dropzone-hint">
                            PNG, JPG or GIF (max 5MB)
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Profile Photo&lt;/label&gt;
    &lt;div class="so-form-file-dropzone" style="padding: 2rem;"&gt;
        &lt;input type="file" accept="image/*"&gt;
        &lt;div class="so-form-file-dropzone-icon"&gt;
            &lt;span class="material-icons"&gt;add_photo_alternate&lt;/span&gt;
        &lt;/div&gt;
        &lt;div class="so-form-file-dropzone-text"&gt;
            &lt;span&gt;Click to upload&lt;/span&gt; or drag and drop
        &lt;/div&gt;
        &lt;div class="so-form-file-dropzone-hint"&gt;
            PNG, JPG or GIF (max 5MB)
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== COLOR INPUT ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Input</h3>
                <p class="so-card-subtitle">A styled color picker with swatch preview.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label">Choose Color</label>
                    <div class="so-form-control-color">
                        <input type="color" value="#1a73e8">
                        <span class="so-form-color-swatch" style="--selected-color: #1a73e8;"></span>
                        <span class="so-form-color-value">#1a73e8</span>
                    </div>
                </div>
                <div class="so-code-block so-code-block-tabbed">
                        <div class="so-code-header">
                            <div class="so-code-tabs">
                                <button class="so-code-tab so-active" data-so-target="#color-input-html">
                                    <span class="material-icons">code</span> HTML
                                </button>
                                <button class="so-code-tab" data-so-target="#color-input-js">
                                    <span class="material-icons">javascript</span> JavaScript
                                </button>
                            </div>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <div class="so-code-body">
                            <div class="so-code-pane so-active" id="color-input-html">
                                <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Choose Color&lt;/label&gt;
    &lt;div class="so-form-control-color"&gt;
        &lt;input type="color" value="#1a73e8"&gt;
        &lt;span class="so-form-color-swatch" style="--selected-color: #1a73e8;"&gt;&lt;/span&gt;
        &lt;span class="so-form-color-value"&gt;#1a73e8&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                            </div>
                            <div class="so-code-pane" id="color-input-js">
                                <pre class="so-code-content"><code class="language-javascript">// Sync color input with swatch and value display
document.querySelectorAll('.so-form-control-color input[type="color"]').forEach(input => {
    input.addEventListener('input', function() {
        const wrapper = this.closest('.so-form-control-color');
        const swatch = wrapper.querySelector('.so-form-color-swatch');
        const valueDisplay = wrapper.querySelector('.so-form-color-value');

        // Update swatch background
        swatch.style.setProperty('--selected-color', this.value);

        // Update hex value display
        if (valueDisplay) {
            valueDisplay.textContent = this.value.toUpperCase();
        }

        // If there's a linked text input (in so-form-color-input)
        const textInput = wrapper.closest('.so-form-color-input')?.querySelector('input[type="text"]');
        if (textInput) {
            textInput.value = this.value.toUpperCase();
        }
    });
});</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- ===================== COLOR INPUT SIZES ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Input Sizes</h3>
                <p class="so-card-subtitle">Small, default, and large color picker variants.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row" style="align-items: center;">
                    <div class="so-form-group">
                        <label class="so-form-label">Small</label>
                        <div class="so-form-control-color so-form-control-color-sm">
                            <input type="color" value="#28c76f">
                            <span class="so-form-color-swatch" style="--selected-color: #28c76f;"></span>
                            <span class="so-form-color-value">#28c76f</span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Default</label>
                        <div class="so-form-control-color">
                            <input type="color" value="#ff9f43">
                            <span class="so-form-color-swatch" style="--selected-color: #ff9f43;"></span>
                            <span class="so-form-color-value">#ff9f43</span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Large</label>
                        <div class="so-form-control-color so-form-control-color-lg">
                            <input type="color" value="#ea5455">
                            <span class="so-form-color-swatch" style="--selected-color: #ea5455;"></span>
                            <span class="so-form-color-value">#ea5455</span>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <pre class="so-code-content"><code class="language-html">&lt;!-- Small --&gt;
&lt;div class="so-form-control-color so-form-control-color-sm"&gt;
    &lt;input type="color" value="#28c76f"&gt;
    &lt;span class="so-form-color-swatch" style="--selected-color: #28c76f;"&gt;&lt;/span&gt;
    &lt;span class="so-form-color-value"&gt;#28c76f&lt;/span&gt;
&lt;/div&gt;

&lt;!-- Default --&gt;
&lt;div class="so-form-control-color"&gt;
    &lt;input type="color" value="#ff9f43"&gt;
    &lt;span class="so-form-color-swatch" style="--selected-color: #ff9f43;"&gt;&lt;/span&gt;
    &lt;span class="so-form-color-value"&gt;#ff9f43&lt;/span&gt;
&lt;/div&gt;

&lt;!-- Large --&gt;
&lt;div class="so-form-control-color so-form-control-color-lg"&gt;
    &lt;input type="color" value="#ea5455"&gt;
    &lt;span class="so-form-color-swatch" style="--selected-color: #ea5455;"&gt;&lt;/span&gt;
    &lt;span class="so-form-color-value"&gt;#ea5455&lt;/span&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>
        </div>

        <!-- ===================== COLOR INPUT WITH HEX FIELD ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Input with Hex Field</h3>
                <p class="so-card-subtitle">Combined color picker with editable hex value input.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-group">
                    <label class="so-form-label">Brand Color</label>
                    <div class="so-form-color-input" style="max-width: 200px;">
                        <div class="so-form-control-color">
                            <input type="color" value="#7367f0">
                            <span class="so-form-color-swatch" style="--selected-color: #7367f0;"></span>
                        </div>
                        <input type="text" class="so-form-control" value="#7367F0" maxlength="7">
                    </div>
                    <span class="so-form-hint">Click swatch or type hex value</span>
                </div>
                <div class="so-code-block so-code-block-tabbed">
                        <div class="so-code-header">
                            <div class="so-code-tabs">
                                <button class="so-code-tab so-active" data-so-target="#color-hex-html">
                                    <span class="material-icons">code</span> HTML
                                </button>
                                <button class="so-code-tab" data-so-target="#color-hex-js">
                                    <span class="material-icons">javascript</span> JavaScript
                                </button>
                            </div>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <div class="so-code-body">
                            <div class="so-code-pane so-active" id="color-hex-html">
                                <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-group"&gt;
    &lt;label class="so-form-label"&gt;Brand Color&lt;/label&gt;
    &lt;div class="so-form-color-input" style="max-width: 200px;"&gt;
        &lt;div class="so-form-control-color"&gt;
            &lt;input type="color" value="#7367f0"&gt;
            &lt;span class="so-form-color-swatch" style="--selected-color: #7367f0;"&gt;&lt;/span&gt;
        &lt;/div&gt;
        &lt;input type="text" class="so-form-control" value="#7367F0" maxlength="7"&gt;
    &lt;/div&gt;
    &lt;span class="so-form-hint"&gt;Click swatch or type hex value&lt;/span&gt;
&lt;/div&gt;</code></pre>
                            </div>
                            <div class="so-code-pane" id="color-hex-js">
                                <pre class="so-code-content"><code class="language-javascript">// Sync color picker with text input (bidirectional)
document.querySelectorAll('.so-form-color-input').forEach(wrapper => {
    const colorInput = wrapper.querySelector('input[type="color"]');
    const textInput = wrapper.querySelector('input[type="text"]');
    const swatch = wrapper.querySelector('.so-form-color-swatch');

    // Color picker -> Text input
    colorInput.addEventListener('input', function() {
        textInput.value = this.value.toUpperCase();
        swatch.style.setProperty('--selected-color', this.value);
    });

    // Text input -> Color picker
    textInput.addEventListener('input', function() {
        let value = this.value;
        if (!value.startsWith('#')) {
            value = '#' + value;
        }
        // Validate hex color
        if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
            colorInput.value = value.toLowerCase();
            swatch.style.setProperty('--selected-color', value);
        }
    });
});</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- ===================== THEME COLORS ===================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Theme Colors</h3>
                <p class="so-card-subtitle">Example of multiple color pickers for theme customization.</p>
            </div>
            <div class="so-card-body">
                <div class="so-form-row">
                    <div class="so-form-group">
                        <label class="so-form-label">Primary</label>
                        <div class="so-form-control-color">
                            <input type="color" value="#1a73e8">
                            <span class="so-form-color-swatch" style="--selected-color: #1a73e8;"></span>
                            <span class="so-form-color-value">#1a73e8</span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Success</label>
                        <div class="so-form-control-color">
                            <input type="color" value="#28c76f">
                            <span class="so-form-color-swatch" style="--selected-color: #28c76f;"></span>
                            <span class="so-form-color-value">#28c76f</span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Danger</label>
                        <div class="so-form-control-color">
                            <input type="color" value="#ea5455">
                            <span class="so-form-color-swatch" style="--selected-color: #ea5455;"></span>
                            <span class="so-form-color-value">#ea5455</span>
                        </div>
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Warning</label>
                        <div class="so-form-control-color">
                            <input type="color" value="#ff9f43">
                            <span class="so-form-color-swatch" style="--selected-color: #ff9f43;"></span>
                            <span class="so-form-color-value">#ff9f43</span>
                        </div>
                    </div>
                </div>
                <div class="so-code-block">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> HTML</span>
                            <button class="so-code-copy" onclick="copyCode(this)"><span class="material-icons">content_copy</span></button>
                        </div>
                        <pre class="so-code-content"><code class="language-html">&lt;div class="so-form-row"&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Primary&lt;/label&gt;
        &lt;div class="so-form-control-color"&gt;
            &lt;input type="color" value="#1a73e8"&gt;
            &lt;span class="so-form-color-swatch" style="--selected-color: #1a73e8;"&gt;&lt;/span&gt;
            &lt;span class="so-form-color-value"&gt;#1a73e8&lt;/span&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Success&lt;/label&gt;
        &lt;div class="so-form-control-color"&gt;
            &lt;input type="color" value="#28c76f"&gt;
            &lt;span class="so-form-color-swatch" style="--selected-color: #28c76f;"&gt;&lt;/span&gt;
            &lt;span class="so-form-color-value"&gt;#28c76f&lt;/span&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Danger&lt;/label&gt;
        &lt;div class="so-form-control-color"&gt;
            &lt;input type="color" value="#ea5455"&gt;
            &lt;span class="so-form-color-swatch" style="--selected-color: #ea5455;"&gt;&lt;/span&gt;
            &lt;span class="so-form-color-value"&gt;#ea5455&lt;/span&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="so-form-group"&gt;
        &lt;label class="so-form-label"&gt;Warning&lt;/label&gt;
        &lt;div class="so-form-control-color"&gt;
            &lt;input type="color" value="#ff9f43"&gt;
            &lt;span class="so-form-color-swatch" style="--selected-color: #ff9f43;"&gt;&lt;/span&gt;
            &lt;span class="so-form-color-value"&gt;#ff9f43&lt;/span&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
                </div>
            </div>

    </div>
</main>

<?php require_once '../includes/footer.php'; ?>

<script>
// File input filename display
document.querySelectorAll('.so-form-control-file input[type="file"]').forEach(input => {
    input.addEventListener('change', function() {
        const fileText = this.closest('.so-form-control-file').querySelector('.so-form-file-text');
        if (this.files.length > 0) {
            const fileNames = Array.from(this.files).map(f => f.name).join(', ');
            fileText.textContent = fileNames;
            fileText.classList.add('has-file');
        } else {
            fileText.textContent = 'No file chosen';
            fileText.classList.remove('has-file');
        }
    });
});

// Dropzone functionality
document.querySelectorAll('.so-form-file-dropzone').forEach(dropzone => {
    const input = dropzone.querySelector('input[type="file"]');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.add('so-dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.remove('so-dragover');
        }, false);
    });

    dropzone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        input.files = files;
        handleDropzoneFiles(files, dropzone);
    }, false);

    input.addEventListener('change', function() {
        handleDropzoneFiles(this.files, dropzone);
    });
});

function handleDropzoneFiles(files, dropzone) {
    if (files.length > 0) {
        const fileNames = Array.from(files).map(f => f.name).join(', ');
        const textEl = dropzone.querySelector('.so-form-file-dropzone-text');
        textEl.innerHTML = '<strong>' + files.length + ' file(s) selected:</strong> ' + fileNames;
    }
}

// Color input sync
document.querySelectorAll('.so-form-control-color input[type="color"]').forEach(input => {
    input.addEventListener('input', function() {
        const wrapper = this.closest('.so-form-control-color');
        const swatch = wrapper.querySelector('.so-form-color-swatch');
        const valueDisplay = wrapper.querySelector('.so-form-color-value');

        if (swatch) swatch.style.setProperty('--selected-color', this.value);
        if (valueDisplay) valueDisplay.textContent = this.value.toUpperCase();

        const textInput = wrapper.closest('.so-form-color-input')?.querySelector('input[type="text"]');
        if (textInput) textInput.value = this.value.toUpperCase();
    });
});

// Color input with hex field bidirectional sync
document.querySelectorAll('.so-form-color-input').forEach(wrapper => {
    const colorInput = wrapper.querySelector('input[type="color"]');
    const textInput = wrapper.querySelector('input[type="text"]');
    const swatch = wrapper.querySelector('.so-form-color-swatch');

    if (textInput) {
        textInput.addEventListener('input', function() {
            let value = this.value;
            if (!value.startsWith('#')) value = '#' + value;
            if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                colorInput.value = value.toLowerCase();
                if (swatch) swatch.style.setProperty('--selected-color', value);
            }
        });
    }
});
</script>
