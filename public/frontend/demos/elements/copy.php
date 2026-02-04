<?php
/**
 * SixOrbit UI Demo - Copy Button
 */
$pageTitle = 'Copy Button';
$pageDescription = 'Click-to-copy utility for any element';

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
            <h1 class="so-page-title">Copy Button</h1>
            <p class="so-page-subtitle">Click-to-copy utility for any element</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

        <!-- Basic Copy Button -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Copy Button</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Simple copy buttons using existing button classes with icon feedback.</p>

                <div class="so-flex so-gap-4 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-sm" data-so-copy data-so-copy-text="Hello, World!">
                        <span class="material-icons">content_copy</span>
                    </button>

                    <button type="button" class="so-btn so-btn-outline so-btn-sm" data-so-copy data-so-copy-text="npm install sixorbit-ui">
                        <span class="material-icons">content_copy</span>
                        <span>Copy Command</span>
                    </button>

                    <button type="button" class="so-btn so-btn-primary so-btn-sm" data-so-copy data-so-copy-text="PROMO2024">
                        <span class="material-icons">content_copy</span>
                        <span>Copy Promo Code</span>
                    </button>
                </div>

                <?= so_code_block('<!-- Icon-only copy button (ghost style) -->
<button class="so-btn so-btn-icon so-btn-ghost so-btn-sm" data-so-copy data-so-copy-text="Hello, World!">
    <span class="material-icons">content_copy</span>
</button>

<!-- Copy button with label (outline style) -->
<button class="so-btn so-btn-outline so-btn-sm" data-so-copy data-so-copy-text="npm install sixorbit-ui">
    <span class="material-icons">content_copy</span>
    <span>Copy Command</span>
</button>

<!-- Copy button with label (primary style) -->
<button class="so-btn so-btn-primary so-btn-sm" data-so-copy data-so-copy-text="PROMO2024">
    <span class="material-icons">content_copy</span>
    <span>Copy Promo Code</span>
</button>', 'html') ?>
            </div>
        </div>

        <!-- Copy from Input -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Copy from Input</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Copy the value from an input field.</p>

                <div class="so-row so-g-4 so-mb-4">
                    <div class="so-col-md-6">
                        <label class="so-form-label">API Key</label>
                        <div class="so-input-group">
                            <input type="text" id="api-key-input" class="so-form-control" value="sk-abc123xyz789def456" readonly>
                            <button type="button" class="so-btn so-btn-icon so-btn-ghost" data-so-copy data-so-copy-target="#api-key-input">
                                <span class="material-icons">content_copy</span>
                            </button>
                        </div>
                    </div>
                    <div class="so-col-md-6">
                        <label class="so-form-label">Share Link</label>
                        <div class="so-input-group">
                            <input type="text" id="share-link-input" class="so-form-control" value="https://example.com/share/abc123" readonly>
                            <button type="button" class="so-btn so-btn-icon so-btn-ghost" data-so-copy data-so-copy-target="#share-link-input">
                                <span class="material-icons">content_copy</span>
                            </button>
                        </div>
                    </div>
                </div>

                <?= so_code_block('<!-- Copy from input using target selector -->
<div class="so-input-group">
    <input type="text" id="api-key" class="so-form-control" value="sk-abc123xyz789" readonly>
    <button class="so-btn so-btn-icon so-btn-ghost" data-so-copy data-so-copy-target="#api-key">
        <span class="material-icons">content_copy</span>
    </button>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Copy Wrapper -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Copy Wrapper</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Wrap content with a copy button container.</p>

                <div class="so-mb-4">
                    <h5 class="so-mb-2">Block Style</h5>
                    <div class="so-copy-block" style="max-width: 500px;">
                        <code class="so-copy-content">npm install @sixorbit/ui --save</code>
                        <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-sm" data-so-copy data-so-copy-target="parent">
                            <span class="material-icons">content_copy</span>
                        </button>
                    </div>
                </div>

                <div class="so-mb-4">
                    <h5 class="so-mb-2">Inline Style</h5>
                    <p>Your order ID is:
                        <span class="so-copy-inline so-copy-inline-show">
                            <code>ORD-2024-ABC123</code>
                            <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-xs" data-so-copy data-so-copy-target="previous">
                                <span class="material-icons">content_copy</span>
                            </button>
                        </span>
                    </p>
                </div>

                <?= so_code_block('<!-- Block copy wrapper -->
<div class="so-copy-block">
    <code class="so-copy-content">npm install @sixorbit/ui --save</code>
    <button class="so-btn so-btn-icon so-btn-ghost so-btn-sm" data-so-copy data-so-copy-target="parent">
        <span class="material-icons">content_copy</span>
    </button>
</div>

<!-- Inline copy (show on hover) -->
<span class="so-copy-inline">
    <code>ORD-2024-ABC123</code>
    <button class="so-btn so-btn-icon so-btn-ghost so-btn-xs" data-so-copy data-so-copy-target="previous">
        <span class="material-icons">content_copy</span>
    </button>
</span>

<!-- Inline copy (always visible) -->
<span class="so-copy-inline so-copy-inline-show">
    <code>ORD-2024-ABC123</code>
    <button class="so-btn so-btn-icon so-btn-ghost so-btn-xs" data-so-copy data-so-copy-target="previous">
        <span class="material-icons">content_copy</span>
    </button>
</span>', 'html') ?>
            </div>
        </div>

        <!-- Copy Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Button Sizes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Copy buttons in different sizes using standard button size classes.</p>

                <div class="so-flex so-gap-4 so-items-center so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-xs" data-so-copy data-so-copy-text="Extra Small">
                        <span class="material-icons">content_copy</span>
                    </button>
                    <span class="so-text-muted">XS</span>

                    <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-sm" data-so-copy data-so-copy-text="Small">
                        <span class="material-icons">content_copy</span>
                    </button>
                    <span class="so-text-muted">SM</span>

                    <button type="button" class="so-btn so-btn-icon so-btn-ghost" data-so-copy data-so-copy-text="Default">
                        <span class="material-icons">content_copy</span>
                    </button>
                    <span class="so-text-muted">Default</span>

                    <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-lg" data-so-copy data-so-copy-text="Large">
                        <span class="material-icons">content_copy</span>
                    </button>
                    <span class="so-text-muted">LG</span>
                </div>

                <?= so_code_block('<!-- Uses standard button size classes -->
<button class="so-btn so-btn-icon so-btn-ghost so-btn-xs" data-so-copy ...>  <!-- Extra small -->
<button class="so-btn so-btn-icon so-btn-ghost so-btn-sm" data-so-copy ...>  <!-- Small -->
<button class="so-btn so-btn-icon so-btn-ghost" data-so-copy ...>            <!-- Default -->
<button class="so-btn so-btn-icon so-btn-ghost so-btn-lg" data-so-copy ...>  <!-- Large -->', 'html') ?>
            </div>
        </div>

        <!-- Button Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Button Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Copy buttons work with all standard button variants.</p>

                <div class="so-flex so-gap-3 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-sm" data-so-copy data-so-copy-text="Ghost">
                        <span class="material-icons">content_copy</span>
                    </button>

                    <button type="button" class="so-btn so-btn-icon so-btn-outline so-btn-sm" data-so-copy data-so-copy-text="Outline">
                        <span class="material-icons">content_copy</span>
                    </button>

                    <button type="button" class="so-btn so-btn-icon so-btn-primary so-btn-sm" data-so-copy data-so-copy-text="Primary">
                        <span class="material-icons">content_copy</span>
                    </button>

                    <button type="button" class="so-btn so-btn-icon so-btn-light-primary so-btn-sm" data-so-copy data-so-copy-text="Light Primary">
                        <span class="material-icons">content_copy</span>
                    </button>

                    <button type="button" class="so-btn so-btn-icon so-btn-success so-btn-sm" data-so-copy data-so-copy-text="Success">
                        <span class="material-icons">content_copy</span>
                    </button>
                </div>

                <?= so_code_block('<!-- Ghost (transparent) - most common for copy buttons -->
<button class="so-btn so-btn-icon so-btn-ghost so-btn-sm" data-so-copy ...>

<!-- Outline -->
<button class="so-btn so-btn-icon so-btn-outline so-btn-sm" data-so-copy ...>

<!-- Primary -->
<button class="so-btn so-btn-icon so-btn-primary so-btn-sm" data-so-copy ...>

<!-- Light Primary -->
<button class="so-btn so-btn-icon so-btn-light-primary so-btn-sm" data-so-copy ...>

<!-- Any variant works! -->
<button class="so-btn so-btn-icon so-btn-success so-btn-sm" data-so-copy ...>', 'html') ?>
            </div>
        </div>

        <!-- Practical Examples -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Practical Examples</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Real-world use cases for copy buttons.</p>

                <!-- API Key Display -->
                <div class="so-mb-5">
                    <h5 class="so-mb-3">API Keys</h5>
                    <div class="so-border so-rounded-md so-p-3" style="max-width: 500px;">
                        <div class="so-flex so-justify-between so-items-center so-mb-2">
                            <span class="so-text-secondary so-text-sm">Public Key</span>
                            <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-xs" data-so-copy data-so-copy-text="pk_live_abc123xyz789">
                                <span class="material-icons">content_copy</span>
                            </button>
                        </div>
                        <code class="so-text-sm">pk_live_abc123xyz789</code>
                    </div>
                </div>

                <!-- Color Codes -->
                <div class="so-mb-5">
                    <h5 class="so-mb-3">Color Codes</h5>
                    <div class="so-flex so-gap-3 so-flex-wrap">
                        <div class="so-flex so-items-center so-gap-2 so-border so-rounded-md so-px-3 so-py-2">
                            <div style="width: 20px; height: 20px; border-radius: 4px; background: #1a73e8;"></div>
                            <code class="so-text-sm">#1a73e8</code>
                            <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-xs" data-so-copy data-so-copy-text="#1a73e8">
                                <span class="material-icons">content_copy</span>
                            </button>
                        </div>
                        <div class="so-flex so-items-center so-gap-2 so-border so-rounded-md so-px-3 so-py-2">
                            <div style="width: 20px; height: 20px; border-radius: 4px; background: #34a853;"></div>
                            <code class="so-text-sm">#34a853</code>
                            <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-xs" data-so-copy data-so-copy-text="#34a853">
                                <span class="material-icons">content_copy</span>
                            </button>
                        </div>
                        <div class="so-flex so-items-center so-gap-2 so-border so-rounded-md so-px-3 so-py-2">
                            <div style="width: 20px; height: 20px; border-radius: 4px; background: #ea4335;"></div>
                            <code class="so-text-sm">#ea4335</code>
                            <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-xs" data-so-copy data-so-copy-text="#ea4335">
                                <span class="material-icons">content_copy</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Code Snippets -->
                <div class="so-mb-5">
                    <h5 class="so-mb-3">Code Snippet</h5>
                    <div class="so-code-block" style="max-width: 600px;">
                        <div class="so-code-header">
                            <span class="so-code-label"><span class="material-icons">code</span> JavaScript</span>
                            <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-sm" data-so-copy data-so-copy-target="#code-snippet-1">
                                <span class="material-icons">content_copy</span>
                            </button>
                        </div>
                        <pre class="so-code-content"><code id="code-snippet-1">const greeting = "Hello, World!";
console.log(greeting);</code></pre>
                    </div>
                </div>

                <!-- Tracking ID -->
                <div class="so-mb-4">
                    <h5 class="so-mb-3">Tracking Information</h5>
                    <div class="so-alert so-alert-info so-alert-sm" style="max-width: 400px;">
                        <span class="material-icons">local_shipping</span>
                        <div class="so-flex-1">
                            <div class="so-text-sm so-mb-1">Tracking Number</div>
                            <div class="so-flex so-items-center so-gap-2">
                                <strong>1Z999AA10123456784</strong>
                                <button type="button" class="so-btn so-btn-icon so-btn-ghost so-btn-xs" data-so-copy data-so-copy-text="1Z999AA10123456784">
                                    <span class="material-icons">content_copy</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript API -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript API</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Programmatic usage with JavaScript.</p>

                <div class="so-mb-4">
                    <button type="button" class="so-btn so-btn-primary so-btn-sm" onclick="demoCopyText()">
                        Copy "Hello from JS!"
                    </button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="demoCopyFromElement()">
                        Copy from Element
                    </button>
                    <button type="button" class="so-btn so-btn-outline so-btn-sm" onclick="demoCreateButton()">
                        Create Button Dynamically
                    </button>
                </div>

                <div id="dynamic-button-container" class="so-mb-4"></div>

                <?= so_code_block('// Copy text directly (without a button)
SOCopy.copyText("Hello, World!", {
    onSuccess: (text) => console.log("Copied:", text),
    onError: (err) => console.error("Failed:", err)
});

// Copy from an element
SOCopy.copyFrom("#my-input", {
    onSuccess: (text) => SOToast.success("Copied!")
});

// Create a copy button dynamically
// Uses standard button classes: so-btn, so-btn-icon, so-btn-ghost, etc.
const btn = SOCopy.createButton({
    target: "#target-element",  // or use text: "Direct text"
    icon: "content_copy",
    label: "Copy",              // omit for icon-only
    size: "sm",                 // xs, sm, (default), lg
    variant: "ghost",           // ghost, outline, primary, etc.
    className: "my-custom-class"
});
document.body.appendChild(btn);

// Get instance from element
const copyInstance = SOCopy.getInstance(buttonElement);
copyInstance.copy();  // Trigger copy programmatically

// Events
button.addEventListener("so:copy:success", (e) => {
    console.log("Copied:", e.detail.text);
});

button.addEventListener("so:copy:error", (e) => {
    console.log("Error:", e.detail.error);
});', 'javascript') ?>
            </div>
        </div>

        <!-- Configuration Options -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Configuration Options</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Available options and data attributes.</p>

                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Option / Attribute</th>
                                <th>Default</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>data-so-copy</code></td>
                                <td>-</td>
                                <td>Required. Enables copy functionality on the element</td>
                            </tr>
                            <tr>
                                <td><code>data-so-copy-text</code></td>
                                <td><code>null</code></td>
                                <td>Direct text to copy</td>
                            </tr>
                            <tr>
                                <td><code>data-so-copy-target</code></td>
                                <td><code>null</code></td>
                                <td>CSS selector, "self", "parent", or "previous"</td>
                            </tr>
                            <tr>
                                <td><code>feedbackDuration</code></td>
                                <td><code>2000</code></td>
                                <td>Duration of success/error feedback (ms)</td>
                            </tr>
                            <tr>
                                <td><code>successIcon</code></td>
                                <td><code>"check"</code></td>
                                <td>Material icon name for success state</td>
                            </tr>
                            <tr>
                                <td><code>defaultIcon</code></td>
                                <td><code>"content_copy"</code></td>
                                <td>Material icon name for default state</td>
                            </tr>
                            <tr>
                                <td><code>showTooltip</code></td>
                                <td><code>true</code></td>
                                <td>Show tooltip feedback on copy (uses SOTooltip)</td>
                            </tr>
                            <tr>
                                <td><code>successText</code></td>
                                <td><code>"Copied!"</code></td>
                                <td>Tooltip text on success</td>
                            </tr>
                            <tr>
                                <td><code>errorText</code></td>
                                <td><code>"Failed to copy"</code></td>
                                <td>Tooltip text on error</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
// Demo functions
function demoCopyText() {
    SOCopy.copyText("Hello from JS!", {
        onSuccess: () => SOToast?.success('Copied: "Hello from JS!"'),
        onError: () => SOToast?.error('Failed to copy')
    });
}

function demoCopyFromElement() {
    SOCopy.copyFrom("#api-key-input", {
        onSuccess: (text) => SOToast?.success(`Copied: ${text}`),
        onError: () => SOToast?.error('Failed to copy')
    });
}

function demoCreateButton() {
    const container = document.getElementById('dynamic-button-container');
    container.innerHTML = '';

    const btn = SOCopy.createButton({
        text: 'Dynamically created text!',
        icon: 'content_copy',
        label: 'Copy Dynamic',
        size: 'sm',
        variant: 'outline'
    });

    container.appendChild(btn);
    SOToast?.info('Button created! Click it to copy.');
}
</script>

<?php
require_once '../includes/footer.php';
?>
