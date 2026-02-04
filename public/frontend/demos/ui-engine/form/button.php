<?php
/**
 * SixOrbit UI Engine - Button Element Demo
 */

$pageTitle = 'Button - UI Engine';
$pageDescription = 'Button element with variants, sizes, icons, and states';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Button</h1>
            <p class="so-page-subtitle">Button element with multiple variants, sizes, icons, and loading states.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Buttons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Button Variants</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-primary">Primary</button>
                    <button type="button" class="so-btn so-btn-secondary">Secondary</button>
                    <button type="button" class="so-btn so-btn-success">Success</button>
                    <button type="button" class="so-btn so-btn-danger">Danger</button>
                    <button type="button" class="so-btn so-btn-warning">Warning</button>
                    <button type="button" class="so-btn so-btn-info">Info</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-buttons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

echo UiEngine::button()->text('Primary')->primary()->render();
echo UiEngine::button()->text('Secondary')->secondary()->render();
echo UiEngine::button()->text('Success')->success()->render();
echo UiEngine::button()->text('Danger')->danger()->render();
echo UiEngine::button()->text('Warning')->warning()->render();
echo UiEngine::button()->text('Info')->info()->render();

// Or use variant() method
echo UiEngine::button()->text('Primary')->variant('primary')->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { UiEngine } from 'sixorbit-ui-engine';

UiEngine.button().text('Primary').primary().toHtml();
UiEngine.button().text('Secondary').secondary().toHtml();
UiEngine.button().text('Success').success().toHtml();
UiEngine.button().text('Danger').danger().toHtml();
UiEngine.button().text('Warning').warning().toHtml();
UiEngine.button().text('Info').info().toHtml();

// Or use variant() method
UiEngine.button().text('Primary').variant('primary').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-primary">Primary</button>
<button type="button" class="so-btn so-btn-secondary">Secondary</button>
<button type="button" class="so-btn so-btn-success">Success</button>
<button type="button" class="so-btn so-btn-danger">Danger</button>
<button type="button" class="so-btn so-btn-warning">Warning</button>
<button type="button" class="so-btn so-btn-info">Info</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Outline Buttons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Outline Buttons</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-outline-primary">Primary</button>
                    <button type="button" class="so-btn so-btn-outline-secondary">Secondary</button>
                    <button type="button" class="so-btn so-btn-outline-success">Success</button>
                    <button type="button" class="so-btn so-btn-outline-danger">Danger</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('outline-buttons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "UiEngine::button()->text('Primary')->primary()->outline()->render();
UiEngine::button()->text('Secondary')->secondary()->outline()->render();
UiEngine::button()->text('Success')->success()->outline()->render();
UiEngine::button()->text('Danger')->danger()->outline()->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "UiEngine.button().text('Primary').primary().outline().toHtml();
UiEngine.button().text('Secondary').secondary().outline().toHtml();
UiEngine.button().text('Success').success().outline().toHtml();
UiEngine.button().text('Danger').danger().outline().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-outline-primary">Primary</button>
<button type="button" class="so-btn so-btn-outline-secondary">Secondary</button>
<button type="button" class="so-btn so-btn-outline-success">Success</button>
<button type="button" class="so-btn so-btn-outline-danger">Danger</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Button Sizes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Button Sizes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-align-items-center so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-primary so-btn-sm">Small</button>
                    <button type="button" class="so-btn so-btn-primary">Default</button>
                    <button type="button" class="so-btn so-btn-primary so-btn-lg">Large</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('button-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small button
UiEngine::button()->text('Small')->primary()->small()->render();
// or
UiEngine::button()->text('Small')->primary()->size('sm')->render();

// Default button
UiEngine::button()->text('Default')->primary()->render();

// Large button
UiEngine::button()->text('Large')->primary()->large()->render();
// or
UiEngine::button()->text('Large')->primary()->size('lg')->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small button
UiEngine.button().text('Small').primary().small().toHtml();
// or
UiEngine.button().text('Small').primary().size('sm').toHtml();

// Default button
UiEngine.button().text('Default').primary().toHtml();

// Large button
UiEngine.button().text('Large').primary().large().toHtml();
// or
UiEngine.button().text('Large').primary().size('lg').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-primary so-btn-sm">Small</button>
<button type="button" class="so-btn so-btn-primary">Default</button>
<button type="button" class="so-btn so-btn-primary so-btn-lg">Large</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Icons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Buttons with Icons</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-primary">
                        <span class="material-icons">save</span> Save
                    </button>
                    <button type="button" class="so-btn so-btn-danger">
                        <span class="material-icons">delete</span> Delete
                    </button>
                    <button type="button" class="so-btn so-btn-success">
                        Download <span class="material-icons">download</span>
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('button-icons', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Icon on left (default)
UiEngine::button()->text('Save')->icon('save')->primary()->render();

// Icon on left explicitly
UiEngine::button()->text('Delete')->icon('delete', 'left')->danger()->render();

// Icon on right
UiEngine::button()->text('Download')->icon('download', 'right')->success()->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Icon on left (default)
UiEngine.button().text('Save').icon('save').primary().toHtml();

// Icon on left explicitly
UiEngine.button().text('Delete').icon('delete', 'left').danger().toHtml();

// Icon on right
UiEngine.button().text('Download').icon('download', 'right').success().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Icon on left -->
<button type="button" class="so-btn so-btn-primary">
    <span class="material-icons">save</span> Save
</button>

<!-- Icon on left -->
<button type="button" class="so-btn so-btn-danger">
    <span class="material-icons">delete</span> Delete
</button>

<!-- Icon on right -->
<button type="button" class="so-btn so-btn-success">
    Download <span class="material-icons">download</span>
</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Icon Only Buttons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Icon-Only Buttons</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-primary so-btn-icon">
                        <span class="material-icons">add</span>
                    </button>
                    <button type="button" class="so-btn so-btn-success so-btn-icon">
                        <span class="material-icons">check</span>
                    </button>
                    <button type="button" class="so-btn so-btn-outline-danger so-btn-icon">
                        <span class="material-icons">delete</span>
                    </button>
                    <button type="button" class="so-btn so-btn-secondary so-btn-icon so-btn-sm">
                        <span class="material-icons">edit</span>
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('button-icon-only', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Icon-only buttons
UiEngine::button()->iconOnly('add')->primary()->render();
UiEngine::button()->iconOnly('check')->success()->render();
UiEngine::button()->iconOnly('delete')->danger()->outline()->render();
UiEngine::button()->iconOnly('edit')->secondary()->small()->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Icon-only buttons
UiEngine.button().iconOnly('add').primary().toHtml();
UiEngine.button().iconOnly('check').success().toHtml();
UiEngine.button().iconOnly('delete').danger().outline().toHtml();
UiEngine.button().iconOnly('edit').secondary().small().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-primary so-btn-icon">
    <span class="material-icons">add</span>
</button>
<button type="button" class="so-btn so-btn-success so-btn-icon">
    <span class="material-icons">check</span>
</button>
<button type="button" class="so-btn so-btn-outline-danger so-btn-icon">
    <span class="material-icons">delete</span>
</button>
<button type="button" class="so-btn so-btn-secondary so-btn-icon so-btn-sm">
    <span class="material-icons">edit</span>
</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Loading State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Loading State</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-primary" disabled>
                        <span class="so-spinner so-spinner-sm so-spinner-light" role="status" aria-hidden="true"></span> Loading...
                    </button>
                    <button type="button" class="so-btn so-btn-secondary" disabled>
                        <span class="so-spinner so-spinner-sm so-spinner-light" role="status" aria-hidden="true"></span> Processing
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('button-loading', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Loading with default text
UiEngine::button()->text('Submit')->primary()->loading(true, 'Loading...')->render();

// Loading with custom text
UiEngine::button()->text('Save')->secondary()->loading(true, 'Processing')->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Loading with default text
UiEngine.button().text('Submit').primary().loading(true, 'Loading...').toHtml();

// Loading with custom text
UiEngine.button().text('Save').secondary().loading(true, 'Processing').toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-primary" disabled>
    <span class="so-spinner so-spinner-sm so-spinner-light"
          role="status" aria-hidden="true"></span> Loading...
</button>
<button type="button" class="so-btn so-btn-secondary" disabled>
    <span class="so-spinner so-spinner-sm so-spinner-light"
          role="status" aria-hidden="true"></span> Processing
</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Button Types -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Button Types</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-primary">Button</button>
                    <button type="submit" class="so-btn so-btn-success">Submit</button>
                    <button type="reset" class="so-btn so-btn-secondary">Reset</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('button-types', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Regular button (default)
UiEngine::button()->text('Button')->primary()->render();

// Submit button
UiEngine::button()->text('Submit')->success()->submit()->render();
// or
UiEngine::button()->text('Submit')->success()->buttonType('submit')->render();

// Reset button
UiEngine::button()->text('Reset')->secondary()->reset()->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Regular button (default)
UiEngine.button().text('Button').primary().toHtml();

// Submit button
UiEngine.button().text('Submit').success().submit().toHtml();
// or
UiEngine.button().text('Submit').success().buttonType('submit').toHtml();

// Reset button
UiEngine.button().text('Reset').secondary().reset().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-primary">Button</button>
<button type="submit" class="so-btn so-btn-success">Submit</button>
<button type="reset" class="so-btn so-btn-secondary">Reset</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Link Buttons -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Link Buttons (as Anchor)</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <a href="#" class="so-btn so-btn-primary" role="button">Link Button</a>
                    <a href="https://example.com" target="_blank" rel="noopener noreferrer" class="so-btn so-btn-success" role="button">Open in New Tab</a>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('button-link', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Button as anchor link
UiEngine::button()
    ->text('Link Button')
    ->href('/dashboard')
    ->primary()
    ->render();

// Open in new tab
UiEngine::button()
    ->text('Open in New Tab')
    ->href('https://example.com')
    ->newTab()
    ->success()
    ->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Button as anchor link
UiEngine.button()
    .text('Link Button')
    .href('/dashboard')
    .primary()
    .toHtml();

// Open in new tab
UiEngine.button()
    .text('Open in New Tab')
    .href('https://example.com')
    .newTab()
    .success()
    .toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<a href="/dashboard" class="so-btn so-btn-primary" role="button">Link Button</a>

<a href="https://example.com" target="_blank" rel="noopener noreferrer"
   class="so-btn so-btn-success" role="button">Open in New Tab</a>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Block Button -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Block Button (Full Width)</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-mb-4">
                    <button type="button" class="so-btn so-btn-primary so-w-100 so-mb-2">Full Width Button</button>
                    <button type="button" class="so-btn so-btn-outline-secondary so-w-100">Another Full Width</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('button-block', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Full width button
UiEngine::button()->text('Full Width Button')->primary()->block()->render();
UiEngine::button()->text('Another Full Width')->secondary()->outline()->block()->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Full width button
UiEngine.button().text('Full Width Button').primary().block().toHtml();
UiEngine.button().text('Another Full Width').secondary().outline().block().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-primary so-w-100">Full Width Button</button>
<button type="button" class="so-btn so-btn-outline-secondary so-w-100">Another Full Width</button>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Disabled State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Disabled State</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-primary" disabled>Disabled Button</button>
                    <button type="button" class="so-btn so-btn-outline-secondary" disabled>Disabled Outline</button>
                    <a href="#" class="so-btn so-btn-success" aria-disabled="true" tabindex="-1">Disabled Link</a>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('button-disabled', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Disabled button
UiEngine::button()->text('Disabled Button')->primary()->disabled()->render();

// Disabled outline
UiEngine::button()->text('Disabled Outline')->secondary()->outline()->disabled()->render();

// Disabled link button (uses aria-disabled)
UiEngine::button()->text('Disabled Link')->href('#')->success()->disabled()->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Disabled button
UiEngine.button().text('Disabled Button').primary().disabled().toHtml();

// Disabled outline
UiEngine.button().text('Disabled Outline').secondary().outline().disabled().toHtml();

// Disabled link button
UiEngine.button().text('Disabled Link').href('#').success().disabled().toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-primary" disabled>Disabled Button</button>
<button type="button" class="so-btn so-btn-outline-secondary" disabled>Disabled Outline</button>

<!-- Link buttons use aria-disabled instead of disabled attribute -->
<a href="#" class="so-btn so-btn-success" aria-disabled="true" tabindex="-1">Disabled Link</a>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Progress Button -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Progress Button</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Buttons with progress indicator and state management for async operations.</p>

                <!-- Live Demo -->
                <div class="so-d-flex so-gap-3 so-flex-wrap so-mb-4">
                    <button type="button" class="so-btn so-btn-primary so-btn-progress" id="demo-progress-auto" data-so-progress data-simulate-on-click="true">
                        <span class="so-btn-progress-bar"></span>
                        <span class="so-btn-text">Click to Upload</span>
                        <span class="so-btn-start"><span class="so-spinner so-spinner-border so-spinner-border-sm"></span> Uploading...</span>
                        <span class="so-btn-done"><span class="material-icons">check</span> Done!</span>
                    </button>
                    <button type="button" class="so-btn so-btn-success so-btn-progress" id="demo-progress-manual">
                        <span class="so-btn-progress-bar"></span>
                        <span class="so-btn-text">Manual Progress</span>
                        <span class="so-btn-start">Processing...</span>
                        <span class="so-btn-done">Complete!</span>
                    </button>
                    <button type="button" class="so-btn so-btn-secondary so-btn-sm" id="demo-progress-control">Start Manual</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('button-progress', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Progress button structure (PHP generates HTML)
// The SOProgressButton JS component handles interactivity

echo '<button type=\"button\" class=\"so-btn so-btn-primary so-btn-progress\"
        data-so-progress data-simulate-on-click=\"true\">
    <span class=\"so-btn-progress-bar\"></span>
    <span class=\"so-btn-text\">Click to Upload</span>
    <span class=\"so-btn-start\">
        <span class=\"so-spinner so-spinner-border so-spinner-border-sm\"></span>
        Uploading...
    </span>
    <span class=\"so-btn-done\">
        <span class=\"material-icons\">check</span> Done!
    </span>
</button>';"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Auto-simulated progress (click to start)
const autoBtn = new SOProgressButton('#upload-btn', {
    autoDisable: true,      // Disable during progress
    simulateOnClick: true,  // Auto-start on click
    simulateSpeed: 150,     // Interval in ms
    simulateIncrement: [5, 15], // Random increment range
    autoReset: 2000         // Reset after 2s
});

// Manual control
const manualBtn = new SOProgressButton('#manual-btn');

// Start progress
manualBtn.start(0);

// Update progress (0-100)
manualBtn.setProgress(50);
manualBtn.increment(10);

// Complete
manualBtn.complete();

// Reset to initial state
manualBtn.reset();

// Simulate progress automatically
manualBtn.simulate({ speed: 100, increment: [5, 20] });"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<button type="button" class="so-btn so-btn-primary so-btn-progress"
        data-so-progress data-simulate-on-click="true">
    <span class="so-btn-progress-bar"></span>
    <span class="so-btn-text">Click to Upload</span>
    <span class="so-btn-start">
        <span class="so-spinner so-spinner-border so-spinner-border-sm"></span>
        Uploading...
    </span>
    <span class="so-btn-done">
        <span class="material-icons">check</span> Done!
    </span>
</button>

<!-- States applied by JS -->
<!-- so-progressing: During progress -->
<!-- so-completed: After completion -->'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- JavaScript Interactivity -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">JavaScript Interactivity</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Standard buttons use CSS styling. For dynamic manipulation, use vanilla JavaScript or the DOM API.</p>

                <!-- Live Demo -->
                <div class="so-d-flex so-gap-2 so-flex-wrap so-align-items-center so-mb-4">
                    <button type="button" class="so-btn so-btn-primary" id="demo-interactive-btn">Interactive Button</button>
                    <button type="button" class="so-btn so-btn-outline-secondary so-btn-sm" id="demo-toggle-loading">Toggle Loading</button>
                    <button type="button" class="so-btn so-btn-outline-secondary so-btn-sm" id="demo-toggle-disabled">Toggle Disabled</button>
                    <button type="button" class="so-btn so-btn-outline-secondary so-btn-sm" id="demo-change-variant">Change Variant</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('button-interactive', [
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const btn = document.querySelector('#my-button');

// Toggle disabled state
btn.disabled = !btn.disabled;

// Toggle loading state
function setLoading(button, loading, loadingText = 'Loading...') {
    if (loading) {
        button.dataset.originalText = button.innerHTML;
        button.innerHTML = `<span class=\"so-spinner so-spinner-border so-spinner-border-sm\"></span> \${loadingText}`;
        button.classList.add('so-btn-loading');
        button.disabled = true;
    } else {
        button.innerHTML = button.dataset.originalText;
        button.classList.remove('so-btn-loading');
        button.disabled = false;
    }
}

// Change variant
function setVariant(button, newVariant) {
    // Remove existing variant classes
    const variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info'];
    variants.forEach(v => {
        button.classList.remove(`so-btn-\${v}`, `so-btn-outline-\${v}`);
    });
    // Add new variant
    button.classList.add(`so-btn-\${newVariant}`);
}

// Change size
function setSize(button, size) {
    button.classList.remove('so-btn-sm', 'so-btn-lg');
    if (size !== 'md') {
        button.classList.add(`so-btn-\${size}`);
    }
}

// Add/remove classes
btn.classList.add('so-btn-outline-primary');
btn.classList.remove('so-btn-primary');
btn.classList.toggle('so-w-100');

// Change text
btn.textContent = 'New Text';

// Add icon
btn.innerHTML = '<span class=\"material-icons\">save</span> Save';

// Update attributes
btn.setAttribute('type', 'submit');
btn.setAttribute('data-action', 'save');

// Event listeners
btn.addEventListener('click', (e) => {
    console.log('Clicked!');
});

btn.addEventListener('mouseenter', () => {
    btn.classList.add('so-btn-lg');
});

btn.addEventListener('mouseleave', () => {
    btn.classList.remove('so-btn-lg');
});"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <!-- Tabbed API Reference -->
                <div class="so-tabs" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#api-php">PHP Class</button>
                    <button class="so-tab" role="tab" data-so-target="#api-js-progress">JS SOProgressButton</button>
                </div>

                <div class="so-tab-content">
                    <!-- PHP Class Reference -->
                    <div class="so-tab-pane so-fade so-show so-active" id="api-php" role="tabpanel">
                        <p class="so-text-secondary so-mb-3"><code>Core\UiEngine\Elements\Form\Button</code> extends <code>Element</code></p>

                        <h5 class="so-mt-4 so-mb-3">Button-Specific Methods</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Method</th><th>Parameters</th><th>Returns</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr class="so-table-info"><td colspan="4"><strong>Type</strong></td></tr>
                                    <tr><td><code>buttonType()</code></td><td><code>string $type</code></td><td><code>static</code></td><td>Set type: <code>'button'</code>, <code>'submit'</code>, <code>'reset'</code></td></tr>
                                    <tr><td><code>submit()</code></td><td>-</td><td><code>static</code></td><td>Set type to submit</td></tr>
                                    <tr><td><code>reset()</code></td><td>-</td><td><code>static</code></td><td>Set type to reset</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Content</strong></td></tr>
                                    <tr><td><code>text()</code></td><td><code>string $text</code></td><td><code>static</code></td><td>Set button text</td></tr>
                                    <tr><td><code>icon()</code></td><td><code>string $icon, string $position = 'left'</code></td><td><code>static</code></td><td>Set Material icon (left or right)</td></tr>
                                    <tr><td><code>iconOnly()</code></td><td><code>string $icon</code></td><td><code>static</code></td><td>Icon-only button (no text)</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Variant</strong></td></tr>
                                    <tr><td><code>variant()</code></td><td><code>string $variant</code></td><td><code>static</code></td><td>Set color variant</td></tr>
                                    <tr><td><code>primary()</code></td><td>-</td><td><code>static</code></td><td>Primary variant</td></tr>
                                    <tr><td><code>secondary()</code></td><td>-</td><td><code>static</code></td><td>Secondary variant</td></tr>
                                    <tr><td><code>success()</code></td><td>-</td><td><code>static</code></td><td>Success variant</td></tr>
                                    <tr><td><code>danger()</code></td><td>-</td><td><code>static</code></td><td>Danger variant</td></tr>
                                    <tr><td><code>warning()</code></td><td>-</td><td><code>static</code></td><td>Warning variant</td></tr>
                                    <tr><td><code>info()</code></td><td>-</td><td><code>static</code></td><td>Info variant</td></tr>
                                    <tr><td><code>light()</code></td><td>-</td><td><code>static</code></td><td>Light variant</td></tr>
                                    <tr><td><code>dark()</code></td><td>-</td><td><code>static</code></td><td>Dark variant</td></tr>
                                    <tr><td><code>link()</code></td><td>-</td><td><code>static</code></td><td>Link variant</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Style</strong></td></tr>
                                    <tr><td><code>outline()</code></td><td><code>bool $outline = true</code></td><td><code>static</code></td><td>Enable outline style</td></tr>
                                    <tr><td><code>size()</code></td><td><code>string $size</code></td><td><code>static</code></td><td>Size: <code>'sm'</code> or <code>'lg'</code></td></tr>
                                    <tr><td><code>small()</code></td><td>-</td><td><code>static</code></td><td>Small size</td></tr>
                                    <tr><td><code>large()</code></td><td>-</td><td><code>static</code></td><td>Large size</td></tr>
                                    <tr><td><code>block()</code></td><td><code>bool $block = true</code></td><td><code>static</code></td><td>Full width button</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>State</strong></td></tr>
                                    <tr><td><code>disabled()</code></td><td><code>bool $disabled = true</code></td><td><code>static</code></td><td>Disable the button</td></tr>
                                    <tr><td><code>loading()</code></td><td><code>bool $loading = true, ?string $loadingText = null</code></td><td><code>static</code></td><td>Show loading spinner</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Link</strong></td></tr>
                                    <tr><td><code>href()</code></td><td><code>string $href, ?string $target = null</code></td><td><code>static</code></td><td>Render as anchor with href</td></tr>
                                    <tr><td><code>newTab()</code></td><td>-</td><td><code>static</code></td><td>Open in new tab (_blank)</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mt-4 so-mb-3">Inherited Methods (from Element)</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Method</th><th>Parameters</th><th>Returns</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr class="so-table-info"><td colspan="4"><strong>Identity</strong></td></tr>
                                    <tr><td><code>id()</code></td><td><code>string $id</code></td><td><code>static</code></td><td>Set element ID</td></tr>
                                    <tr><td><code>getId()</code></td><td>-</td><td><code>string|null</code></td><td>Get element ID</td></tr>
                                    <tr><td><code>tag()</code></td><td><code>string $tag</code></td><td><code>static</code></td><td>Set HTML tag name</td></tr>
                                    <tr><td><code>content()</code></td><td><code>string $content</code></td><td><code>static</code></td><td>Set text content</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>CSS Classes (HasClasses trait)</strong></td></tr>
                                    <tr><td><code>class()</code></td><td><code>string|array $classes</code></td><td><code>static</code></td><td>Add CSS class(es)</td></tr>
                                    <tr><td><code>addClass()</code></td><td><code>string $class</code></td><td><code>static</code></td><td>Add single CSS class</td></tr>
                                    <tr><td><code>removeClass()</code></td><td><code>string $class</code></td><td><code>static</code></td><td>Remove CSS class</td></tr>
                                    <tr><td><code>toggleClass()</code></td><td><code>string $class, ?bool $force</code></td><td><code>static</code></td><td>Toggle CSS class</td></tr>
                                    <tr><td><code>hasClass()</code></td><td><code>string $class</code></td><td><code>bool</code></td><td>Check if has class</td></tr>
                                    <tr><td><code>classIf()</code></td><td><code>array $classes</code></td><td><code>static</code></td><td>Add conditional classes</td></tr>
                                    <tr><td><code>addClassWhen()</code></td><td><code>string $class, bool $condition</code></td><td><code>static</code></td><td>Add class conditionally</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>HTML Attributes (HasAttributes trait)</strong></td></tr>
                                    <tr><td><code>attr()</code></td><td><code>string $name, mixed $value</code></td><td><code>static</code></td><td>Set HTML attribute</td></tr>
                                    <tr><td><code>attrs()</code></td><td><code>array $attributes</code></td><td><code>static</code></td><td>Set multiple attributes</td></tr>
                                    <tr><td><code>getAttr()</code></td><td><code>string $name, mixed $default</code></td><td><code>mixed</code></td><td>Get attribute value</td></tr>
                                    <tr><td><code>hasAttr()</code></td><td><code>string $name</code></td><td><code>bool</code></td><td>Check if has attribute</td></tr>
                                    <tr><td><code>removeAttr()</code></td><td><code>string $name</code></td><td><code>static</code></td><td>Remove attribute</td></tr>
                                    <tr><td><code>tabindex()</code></td><td><code>int $index</code></td><td><code>static</code></td><td>Set tabindex</td></tr>
                                    <tr><td><code>title()</code></td><td><code>string $title</code></td><td><code>static</code></td><td>Set title (tooltip)</td></tr>
                                    <tr><td><code>style()</code></td><td><code>string|array $style</code></td><td><code>static</code></td><td>Set inline style</td></tr>
                                    <tr><td><code>aria()</code></td><td><code>string $name, mixed $value</code></td><td><code>static</code></td><td>Set ARIA attribute</td></tr>
                                    <tr><td><code>role()</code></td><td><code>string $role</code></td><td><code>static</code></td><td>Set role attribute</td></tr>
                                    <tr><td><code>autofocus()</code></td><td><code>bool $autofocus</code></td><td><code>static</code></td><td>Set autofocus</td></tr>
                                    <tr><td><code>hidden()</code></td><td><code>bool $hidden</code></td><td><code>static</code></td><td>Set hidden attribute</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Data Attributes (HasDataAttributes trait)</strong></td></tr>
                                    <tr><td><code>data()</code></td><td><code>string $name, mixed $value</code></td><td><code>static</code></td><td>Set data-so-* attribute</td></tr>
                                    <tr><td><code>dataAttrs()</code></td><td><code>array $attributes</code></td><td><code>static</code></td><td>Set multiple data attrs</td></tr>
                                    <tr><td><code>getData()</code></td><td><code>string $name</code></td><td><code>mixed</code></td><td>Get data attribute</td></tr>
                                    <tr><td><code>hasData()</code></td><td><code>string $name</code></td><td><code>bool</code></td><td>Check if has data attr</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Events (HasEvents trait)</strong></td></tr>
                                    <tr><td><code>on()</code></td><td><code>string $event, string $handler</code></td><td><code>static</code></td><td>Set event handler</td></tr>
                                    <tr><td><code>onClick()</code></td><td><code>string $handler</code></td><td><code>static</code></td><td>Set click handler</td></tr>
                                    <tr><td><code>onChange()</code></td><td><code>string $handler</code></td><td><code>static</code></td><td>Set change handler</td></tr>
                                    <tr><td><code>onBlur()</code></td><td><code>string $handler</code></td><td><code>static</code></td><td>Set blur handler</td></tr>
                                    <tr><td><code>onFocus()</code></td><td><code>string $handler</code></td><td><code>static</code></td><td>Set focus handler</td></tr>
                                    <tr><td><code>onKeyUp()</code></td><td><code>string $handler</code></td><td><code>static</code></td><td>Set keyup handler</td></tr>
                                    <tr><td><code>onKeyDown()</code></td><td><code>string $handler</code></td><td><code>static</code></td><td>Set keydown handler</td></tr>
                                    <tr><td><code>onMouseEnter()</code></td><td><code>string $handler</code></td><td><code>static</code></td><td>Set mouseenter handler</td></tr>
                                    <tr><td><code>onMouseLeave()</code></td><td><code>string $handler</code></td><td><code>static</code></td><td>Set mouseleave handler</td></tr>
                                    <tr><td><code>onHover()</code></td><td><code>string $enter, string $leave</code></td><td><code>static</code></td><td>Set hover handlers</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Rendering</strong></td></tr>
                                    <tr><td><code>render()</code></td><td>-</td><td><code>string</code></td><td>Render HTML string</td></tr>
                                    <tr><td><code>toArray()</code></td><td>-</td><td><code>array</code></td><td>Export as config array</td></tr>
                                    <tr><td><code>toJson()</code></td><td>-</td><td><code>string</code></td><td>Export as JSON</td></tr>
                                    <tr><td><code>when()</code></td><td><code>bool $condition, callable $callback</code></td><td><code>static</code></td><td>Conditional method</td></tr>
                                    <tr><td><code>unless()</code></td><td><code>bool $condition, callable $callback</code></td><td><code>static</code></td><td>Inverse conditional</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- JS SOProgressButton Class Reference -->
                    <div class="so-tab-pane so-fade" id="api-js-progress" role="tabpanel">
                        <p class="so-text-secondary so-mb-3"><code>SOProgressButton</code> extends <code>SOComponent</code></p>

                        <h5 class="so-mt-4 so-mb-3">Constructor Options</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Option</th><th>Type</th><th>Default</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td><code>autoDisable</code></td><td><code>boolean</code></td><td><code>true</code></td><td>Disable button during progress</td></tr>
                                    <tr><td><code>autoReset</code></td><td><code>number</code></td><td><code>0</code></td><td>Auto reset after complete (ms, 0 = disabled)</td></tr>
                                    <tr><td><code>simulateOnClick</code></td><td><code>boolean</code></td><td><code>false</code></td><td>Auto-simulate progress on click</td></tr>
                                    <tr><td><code>simulateSpeed</code></td><td><code>number</code></td><td><code>150</code></td><td>Interval for simulated progress (ms)</td></tr>
                                    <tr><td><code>simulateIncrement</code></td><td><code>number[]</code></td><td><code>[5, 15]</code></td><td>Random increment range [min, max]</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mt-4 so-mb-3">Methods</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Method</th><th>Parameters</th><th>Returns</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr class="so-table-info"><td colspan="4"><strong>Progress Control</strong></td></tr>
                                    <tr><td><code>start()</code></td><td><code>initialProgress = 0</code></td><td><code>this</code></td><td>Start progress (enter progressing state)</td></tr>
                                    <tr><td><code>setProgress()</code></td><td><code>value</code></td><td><code>this</code></td><td>Set progress value (0-100)</td></tr>
                                    <tr><td><code>increment()</code></td><td><code>amount</code></td><td><code>this</code></td><td>Increment progress by amount</td></tr>
                                    <tr><td><code>complete()</code></td><td>-</td><td><code>this</code></td><td>Complete (enter completed state)</td></tr>
                                    <tr><td><code>reset()</code></td><td>-</td><td><code>this</code></td><td>Reset to initial state</td></tr>
                                    <tr><td><code>simulate()</code></td><td><code>{ speed?, increment? }</code></td><td><code>this</code></td><td>Simulate progress automatically</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>State Getters</strong></td></tr>
                                    <tr><td><code>getProgress()</code></td><td>-</td><td><code>number</code></td><td>Get current progress (0-100)</td></tr>
                                    <tr><td><code>getState()</code></td><td>-</td><td><code>string</code></td><td>Get state: idle, progressing, completed</td></tr>
                                    <tr><td><code>isProgressing()</code></td><td>-</td><td><code>boolean</code></td><td>Check if progressing</td></tr>
                                    <tr><td><code>isCompleted()</code></td><td>-</td><td><code>boolean</code></td><td>Check if completed</td></tr>
                                    <tr><td><code>isIdle()</code></td><td>-</td><td><code>boolean</code></td><td>Check if idle</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Content</strong></td></tr>
                                    <tr><td><code>setText()</code></td><td><code>html</code></td><td><code>this</code></td><td>Set main text content</td></tr>
                                    <tr><td><code>setStartContent()</code></td><td><code>html</code></td><td><code>this</code></td><td>Set content shown during progress</td></tr>
                                    <tr><td><code>setDoneContent()</code></td><td><code>html</code></td><td><code>this</code></td><td>Set content shown on complete</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mt-4 so-mb-3">Events</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Event</th><th>Detail</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td><code>so:progress:start</code></td><td><code>{ progress, state }</code></td><td>Progress started</td></tr>
                                    <tr><td><code>so:progress:update</code></td><td><code>{ progress, previousProgress, state }</code></td><td>Progress updated</td></tr>
                                    <tr><td><code>so:progress:complete</code></td><td><code>{ progress: 100, state }</code></td><td>Progress completed</td></tr>
                                    <tr><td><code>so:progress:reset</code></td><td><code>{ progress: 0, state }</code></td><td>Progress reset</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mt-4 so-mb-3">Event Usage Example</h5>
                        <?= so_code_tabs('button-progress-events', [
                            ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript',
                             'code' => "const progressBtn = new SOProgressButton('#upload-btn', {
    autoDisable: true,
    autoReset: 3000
});

// Listen for progress events
progressBtn.element.addEventListener('so:progress:start', (e) => {
    console.log('Started at:', e.detail.progress);
});

progressBtn.element.addEventListener('so:progress:update', (e) => {
    console.log('Progress:', e.detail.progress, '%');
    console.log('Previous:', e.detail.previousProgress, '%');
});

progressBtn.element.addEventListener('so:progress:complete', (e) => {
    console.log('Completed!');
    showNotification('Upload complete!');
});

progressBtn.element.addEventListener('so:progress:reset', (e) => {
    console.log('Reset to initial state');
});

// Programmatic control with async operation
async function uploadFile(file) {
    progressBtn.start(0);

    const xhr = new XMLHttpRequest();
    xhr.upload.onprogress = (e) => {
        if (e.lengthComputable) {
            progressBtn.setProgress((e.loaded / e.total) * 100);
        }
    };
    xhr.onload = () => progressBtn.complete();
    xhr.onerror = () => progressBtn.reset();

    xhr.open('POST', '/upload');
    xhr.send(file);
}"]
                        ]) ?>

                        <h5 class="so-mt-4 so-mb-3">Inherited Methods (from SOComponent)</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Method</th><th>Parameters</th><th>Returns</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr class="so-table-info"><td colspan="4"><strong>Class Manipulation</strong></td></tr>
                                    <tr><td><code>addClass()</code></td><td><code>...classes</code></td><td><code>this</code></td><td>Add CSS class(es)</td></tr>
                                    <tr><td><code>removeClass()</code></td><td><code>...classes</code></td><td><code>this</code></td><td>Remove CSS class(es)</td></tr>
                                    <tr><td><code>toggleClass()</code></td><td><code>className, force?</code></td><td><code>this</code></td><td>Toggle CSS class</td></tr>
                                    <tr><td><code>hasClass()</code></td><td><code>className</code></td><td><code>boolean</code></td><td>Check if has class</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Data Attributes</strong></td></tr>
                                    <tr><td><code>getData()</code></td><td><code>name</code></td><td><code>string|null</code></td><td>Get data-so-* value</td></tr>
                                    <tr><td><code>setData()</code></td><td><code>name, value</code></td><td><code>this</code></td><td>Set data-so-* value</td></tr>
                                    <tr><td><code>removeData()</code></td><td><code>name</code></td><td><code>this</code></td><td>Remove data-so-* attr</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Event Management</strong></td></tr>
                                    <tr><td><code>on()</code></td><td><code>event, handler, target?, options?</code></td><td><code>this</code></td><td>Add event listener</td></tr>
                                    <tr><td><code>off()</code></td><td><code>event, handler, target?</code></td><td><code>this</code></td><td>Remove event listener</td></tr>
                                    <tr><td><code>once()</code></td><td><code>event, handler, target?</code></td><td><code>this</code></td><td>Add one-time listener</td></tr>
                                    <tr><td><code>emit()</code></td><td><code>name, detail?, bubbles?, cancelable?</code></td><td><code>boolean</code></td><td>Emit event (auto-prefixed so:)</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Lifecycle</strong></td></tr>
                                    <tr><td><code>enable()</code></td><td>-</td><td><code>this</code></td><td>Enable the component</td></tr>
                                    <tr><td><code>disable()</code></td><td>-</td><td><code>this</code></td><td>Disable the component</td></tr>
                                    <tr><td><code>isDisabled()</code></td><td>-</td><td><code>boolean</code></td><td>Check if disabled</td></tr>
                                    <tr><td><code>destroy()</code></td><td>-</td><td>-</td><td>Destroy and cleanup</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PHP to JS Configuration -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP to JavaScript Configuration</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Pass button configuration from PHP to JavaScript for dynamic initialization.</p>

                <?= so_code_tabs('button-php-to-js', [
                    ['label' => 'PHP', 'language' => 'php', 'icon' => 'data_object',
                     'code' => "// Build button in PHP
\$button = UiEngine::button()
    ->text('Upload File')
    ->icon('cloud_upload')
    ->primary()
    ->id('upload-btn')
    ->data('action', 'upload')
    ->data('max-size', '10MB');

// Render button
echo \$button->render();

// Export as array for JS
\$config = \$button->toArray();

// Export as JSON for inline script
\$jsonConfig = \$button->toJson();"],
                    ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript',
                     'code' => "// Read data attributes from PHP-rendered button
const btn = document.querySelector('#upload-btn');
const action = btn.dataset.soAction; // 'upload'
const maxSize = btn.dataset.soMaxSize; // '10MB'

// Initialize progress button on PHP-rendered element
const progressBtn = new SOProgressButton('#upload-btn', {
    autoDisable: true,
    simulateOnClick: false
});

// Handle upload with progress
btn.addEventListener('click', async () => {
    const file = await selectFile();
    if (file.size > parseSize(maxSize)) {
        alert('File too large!');
        return;
    }

    progressBtn.start(0);
    await uploadWithProgress(file, (progress) => {
        progressBtn.setProgress(progress);
    });
    progressBtn.complete();
});

// Dynamic button creation from PHP config
const config = <?= \$button->toJson() ?>;
// config = { text: 'Upload File', icon: 'cloud_upload', variant: 'primary', ... }"]
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Data Attribute Mapping</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered so-table-sm">
                        <thead class="so-table-light">
                            <tr><th>PHP Method</th><th>Data Attribute</th><th>JS Access</th></tr>
                        </thead>
                        <tbody>
                            <tr><td><code>data('loading', 'true')</code></td><td><code>data-so-loading</code></td><td><code>el.dataset.soLoading</code></td></tr>
                            <tr><td><code>data('loading-text', 'Saving...')</code></td><td><code>data-so-loading-text</code></td><td><code>el.dataset.soLoadingText</code></td></tr>
                            <tr><td><code>data('action', 'save')</code></td><td><code>data-so-action</code></td><td><code>el.dataset.soAction</code></td></tr>
                            <tr><td><code>data('confirm', 'Are you sure?')</code></td><td><code>data-so-confirm</code></td><td><code>el.dataset.soConfirm</code></td></tr>
                            <tr><td><code>onClick('handleClick()')</code></td><td><code>data-on-click</code></td><td><code>el.dataset.onClick</code></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered so-table-sm">
                        <thead class="so-table-light">
                            <tr><th>Class</th><th>Description</th></tr>
                        </thead>
                        <tbody>
                            <tr class="so-table-info"><td colspan="2"><strong>Base</strong></td></tr>
                            <tr><td><code>so-btn</code></td><td>Base button class (required)</td></tr>

                            <tr class="so-table-info"><td colspan="2"><strong>Variants</strong></td></tr>
                            <tr><td><code>so-btn-primary</code></td><td>Primary color variant</td></tr>
                            <tr><td><code>so-btn-secondary</code></td><td>Secondary color variant</td></tr>
                            <tr><td><code>so-btn-success</code></td><td>Success (green) variant</td></tr>
                            <tr><td><code>so-btn-danger</code></td><td>Danger (red) variant</td></tr>
                            <tr><td><code>so-btn-warning</code></td><td>Warning (yellow) variant</td></tr>
                            <tr><td><code>so-btn-info</code></td><td>Info (cyan) variant</td></tr>
                            <tr><td><code>so-btn-light</code></td><td>Light variant</td></tr>
                            <tr><td><code>so-btn-dark</code></td><td>Dark variant</td></tr>
                            <tr><td><code>so-btn-link</code></td><td>Link-style button</td></tr>

                            <tr class="so-table-info"><td colspan="2"><strong>Outline Variants</strong></td></tr>
                            <tr><td><code>so-btn-outline-primary</code></td><td>Outline primary</td></tr>
                            <tr><td><code>so-btn-outline-secondary</code></td><td>Outline secondary</td></tr>
                            <tr><td><code>so-btn-outline-*</code></td><td>Other outline variants...</td></tr>

                            <tr class="so-table-info"><td colspan="2"><strong>Sizes</strong></td></tr>
                            <tr><td><code>so-btn-sm</code></td><td>Small button</td></tr>
                            <tr><td><code>so-btn-lg</code></td><td>Large button</td></tr>

                            <tr class="so-table-info"><td colspan="2"><strong>Layout</strong></td></tr>
                            <tr><td><code>so-w-100</code></td><td>Full width (block button)</td></tr>
                            <tr><td><code>so-btn-icon</code></td><td>Icon-only button (square)</td></tr>

                            <tr class="so-table-info"><td colspan="2"><strong>States</strong></td></tr>
                            <tr><td><code>so-btn-loading</code></td><td>Loading state</td></tr>
                            <tr><td><code>so-btn-progress</code></td><td>Progress button container</td></tr>
                            <tr><td><code>so-progressing</code></td><td>Progress in progress (JS)</td></tr>
                            <tr><td><code>so-completed</code></td><td>Progress completed (JS)</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize auto-simulate progress button
    if (document.getElementById('demo-progress-auto')) {
        new SOProgressButton('#demo-progress-auto', {
            simulateOnClick: true,
            autoReset: 2000
        });
    }

    // Initialize manual progress button
    const manualBtn = document.getElementById('demo-progress-manual');
    const controlBtn = document.getElementById('demo-progress-control');

    if (manualBtn && controlBtn) {
        const progressInstance = new SOProgressButton('#demo-progress-manual', {
            autoDisable: true
        });

        let intervalId = null;

        controlBtn.addEventListener('click', function() {
            if (progressInstance.isIdle()) {
                progressInstance.start(0);
                controlBtn.textContent = 'Increment +10';

                // Auto increment every 500ms
                intervalId = setInterval(() => {
                    if (progressInstance.getProgress() >= 100) {
                        clearInterval(intervalId);
                        controlBtn.textContent = 'Reset';
                    } else {
                        progressInstance.increment(10);
                    }
                }, 500);
            } else if (progressInstance.isProgressing()) {
                clearInterval(intervalId);
                progressInstance.increment(10);
                if (progressInstance.getProgress() >= 100) {
                    controlBtn.textContent = 'Reset';
                }
            } else if (progressInstance.isCompleted()) {
                progressInstance.reset();
                controlBtn.textContent = 'Start Manual';
            }
        });
    }

    // Interactive button demo
    const interactiveBtn = document.getElementById('demo-interactive-btn');
    const toggleLoadingBtn = document.getElementById('demo-toggle-loading');
    const toggleDisabledBtn = document.getElementById('demo-toggle-disabled');
    const changeVariantBtn = document.getElementById('demo-change-variant');

    if (interactiveBtn) {
        let isLoading = false;
        let originalHtml = interactiveBtn.innerHTML;
        const variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info'];
        let variantIndex = 0;

        toggleLoadingBtn?.addEventListener('click', function() {
            isLoading = !isLoading;
            if (isLoading) {
                originalHtml = interactiveBtn.innerHTML;
                interactiveBtn.innerHTML = '<span class="so-spinner so-spinner-border so-spinner-border-sm"></span> Loading...';
                interactiveBtn.classList.add('so-btn-loading');
            } else {
                interactiveBtn.innerHTML = originalHtml;
                interactiveBtn.classList.remove('so-btn-loading');
            }
        });

        toggleDisabledBtn?.addEventListener('click', function() {
            interactiveBtn.disabled = !interactiveBtn.disabled;
        });

        changeVariantBtn?.addEventListener('click', function() {
            // Remove current variant
            variants.forEach(v => {
                interactiveBtn.classList.remove(`so-btn-${v}`);
            });
            // Add next variant
            variantIndex = (variantIndex + 1) % variants.length;
            interactiveBtn.classList.add(`so-btn-${variants[variantIndex]}`);
        });
    }
});
</script>

<?php require_once '../../includes/footer.php'; ?>
