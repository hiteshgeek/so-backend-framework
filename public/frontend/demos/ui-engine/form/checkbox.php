<?php
/**
 * SixOrbit UI Engine - Checkbox Element Demo
 */

$pageTitle = 'Checkbox - UI Engine';
$pageDescription = 'Checkbox input for boolean and multiple selections';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Checkbox</h1>
            <p class="so-page-subtitle">Checkbox element for boolean values and multiple selections with various styling options.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Checkbox -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Checkbox</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <label class="so-checkbox">
                    <input type="checkbox" name="terms">
                    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                    <span class="so-checkbox-label">I agree to the terms and conditions</span>
                </label>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-checkbox', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$checkbox = UiEngine::checkbox('terms')
    ->label('I agree to the terms and conditions');

echo \$checkbox->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const checkbox = UiEngine.checkbox('terms')
    .label('I agree to the terms and conditions');

document.getElementById('container').innerHTML = checkbox.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<label class="so-checkbox">
    <input type="checkbox" name="terms">
    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
    <span class="so-checkbox-label">I agree to the terms and conditions</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Checkbox Group -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Checkbox Group</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <label class="so-form-label so-mb-2">Select your interests</label>
                <div class="so-checkbox-group so-checkbox-group-vertical">
                    <label class="so-checkbox">
                        <input type="checkbox" name="interests[]" value="tech">
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Technology</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" name="interests[]" value="sports">
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Sports</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" name="interests[]" value="music">
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Music</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-group', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Using options() method for checkbox groups
\$checkboxGroup = UiEngine::checkbox('interests')
    ->label('Select your interests')
    ->options([
        'tech' => 'Technology',
        'sports' => 'Sports',
        'music' => 'Music',
    ]);

echo \$checkboxGroup->render();

// Or add options individually
\$checkboxGroup = UiEngine::checkbox('interests')
    ->label('Select your interests')
    ->option('tech', 'Technology')
    ->option('sports', 'Sports')
    ->option('music', 'Music');

echo \$checkboxGroup->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const checkboxGroup = UiEngine.checkbox('interests')
    .label('Select your interests')
    .options({
        tech: 'Technology',
        sports: 'Sports',
        music: 'Music',
    });

document.getElementById('container').innerHTML = checkboxGroup.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label so-mb-2">Select your interests</label>
    <div class="so-checkbox-group so-checkbox-group-vertical">
        <label class="so-checkbox">
            <input type="checkbox" name="interests[]" value="tech">
            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
            <span class="so-checkbox-label">Technology</span>
        </label>
        <label class="so-checkbox">
            <input type="checkbox" name="interests[]" value="sports">
            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
            <span class="so-checkbox-label">Sports</span>
        </label>
        <label class="so-checkbox">
            <input type="checkbox" name="interests[]" value="music">
            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
            <span class="so-checkbox-label">Music</span>
        </label>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Inline Checkboxes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Inline Checkboxes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <label class="so-form-label so-mb-2">Size options</label>
                <div class="so-checkbox-group so-checkbox-group-inline">
                    <label class="so-checkbox">
                        <input type="checkbox" name="sizes[]" value="sm">
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Small</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" name="sizes[]" value="md">
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Medium</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" name="sizes[]" value="lg">
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Large</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-inline', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$checkboxGroup = UiEngine::checkbox('sizes')
    ->label('Size options')
    ->inline()  // Display inline instead of vertical
    ->options([
        'sm' => 'Small',
        'md' => 'Medium',
        'lg' => 'Large',
    ]);

echo \$checkboxGroup->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const checkboxGroup = UiEngine.checkbox('sizes')
    .label('Size options')
    .inline()
    .options({
        sm: 'Small',
        md: 'Medium',
        lg: 'Large',
    });

document.getElementById('container').innerHTML = checkboxGroup.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label so-mb-2">Size options</label>
    <div class="so-checkbox-group so-checkbox-group-inline">
        <label class="so-checkbox">
            <input type="checkbox" name="sizes[]" value="sm">
            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
            <span class="so-checkbox-label">Small</span>
        </label>
        <label class="so-checkbox">
            <input type="checkbox" name="sizes[]" value="md">
            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
            <span class="so-checkbox-label">Medium</span>
        </label>
        <label class="so-checkbox">
            <input type="checkbox" name="sizes[]" value="lg">
            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
            <span class="so-checkbox-label">Large</span>
        </label>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Checked & Disabled States -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">States</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-checkbox-group so-checkbox-group-vertical">
                    <label class="so-checkbox">
                        <input type="checkbox" name="checked" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Checked checkbox</span>
                    </label>
                    <label class="so-checkbox so-disabled">
                        <input type="checkbox" name="disabled" disabled>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Disabled checkbox</span>
                    </label>
                    <label class="so-checkbox so-disabled">
                        <input type="checkbox" name="both" checked disabled>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Checked and disabled</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-states', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Checked checkbox
UiEngine::checkbox('checked')
    ->label('Checked checkbox')
    ->checked();

// Disabled checkbox
UiEngine::checkbox('disabled')
    ->label('Disabled checkbox')
    ->disabled();

// Checked and disabled
UiEngine::checkbox('both')
    ->label('Checked and disabled')
    ->checked()
    ->disabled();

// Unchecked (explicitly)
UiEngine::checkbox('unchecked')
    ->label('Unchecked checkbox')
    ->unchecked();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Checked checkbox
UiEngine.checkbox('checked')
    .label('Checked checkbox')
    .checked();

// Disabled checkbox
UiEngine.checkbox('disabled')
    .label('Disabled checkbox')
    .disabled();

// Checked and disabled
UiEngine.checkbox('both')
    .label('Checked and disabled')
    .checked()
    .disabled();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Checked checkbox -->
<label class="so-checkbox">
    <input type="checkbox" name="checked" checked>
    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
    <span class="so-checkbox-label">Checked checkbox</span>
</label>

<!-- Disabled checkbox -->
<label class="so-checkbox so-disabled">
    <input type="checkbox" name="disabled" disabled>
    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
    <span class="so-checkbox-label">Disabled checkbox</span>
</label>

<!-- Checked and disabled -->
<label class="so-checkbox so-disabled">
    <input type="checkbox" name="both" checked disabled>
    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
    <span class="so-checkbox-label">Checked and disabled</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Indeterminate State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Indeterminate State</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">The indeterminate state represents a "partial" selection, commonly used in "select all" patterns where some but not all child items are selected.</p>

                <!-- Live Demo -->
                <label class="so-checkbox" id="parent-checkbox">
                    <input type="checkbox" name="select_all" data-so-indeterminate="true">
                    <span class="so-checkbox-box"><span class="material-icons">remove</span></span>
                    <span class="so-checkbox-label">Select All (Indeterminate)</span>
                </label>

                <div class="so-checkbox-group so-checkbox-group-vertical so-ms-4 so-mt-2">
                    <label class="so-checkbox">
                        <input type="checkbox" name="items[]" value="1" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Item 1 (selected)</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" name="items[]" value="2">
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Item 2</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" name="items[]" value="3" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Item 3 (selected)</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-indeterminate', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Single indeterminate checkbox
\$selectAll = UiEngine::checkbox('select_all')
    ->label('Select All')
    ->indeterminate();  // Sets indeterminate state

echo \$selectAll->render();

// Note: Indeterminate state can only be set via JavaScript
// The PHP method adds data-so-indeterminate=\"true\" attribute
// which JS can detect and apply the visual state"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Set indeterminate state via JavaScript
const checkbox = document.querySelector('input[name=\"select_all\"]');
checkbox.indeterminate = true;

// Pattern for \"Select All\" with child checkboxes
const parentCheckbox = document.querySelector('#parent-checkbox input');
const childCheckboxes = document.querySelectorAll('input[name=\"items[]\"]');

function updateParentState() {
    const checkedCount = [...childCheckboxes].filter(cb => cb.checked).length;

    if (checkedCount === 0) {
        parentCheckbox.checked = false;
        parentCheckbox.indeterminate = false;
    } else if (checkedCount === childCheckboxes.length) {
        parentCheckbox.checked = true;
        parentCheckbox.indeterminate = false;
    } else {
        parentCheckbox.checked = false;
        parentCheckbox.indeterminate = true;
    }
}

// Listen for changes on child checkboxes
childCheckboxes.forEach(cb => {
    cb.addEventListener('change', updateParentState);
});

// Toggle all children when parent is clicked
parentCheckbox.addEventListener('change', () => {
    childCheckboxes.forEach(cb => {
        cb.checked = parentCheckbox.checked;
    });
});"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<label class="so-checkbox">
    <input type="checkbox" name="select_all" data-so-indeterminate="true">
    <span class="so-checkbox-box"><span class="material-icons">remove</span></span>
    <span class="so-checkbox-label">Select All</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Value -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Value</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <label class="so-checkbox">
                    <input type="checkbox" name="newsletter" value="1">
                    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                    <span class="so-checkbox-label">Subscribe to newsletter</span>
                </label>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-value', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Single checkbox with explicit value
\$newsletter = UiEngine::checkbox('newsletter')
    ->label('Subscribe to newsletter')
    ->value('1');  // Will submit '1' when checked

echo \$newsletter->render();

// Pre-check if value matches (useful for edit forms)
\$settings = ['newsletter' => '1']; // From database
\$newsletter = UiEngine::checkbox('newsletter')
    ->label('Subscribe to newsletter')
    ->value('1')
    ->checked(\$settings['newsletter'] === '1');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const newsletter = UiEngine.checkbox('newsletter')
    .label('Subscribe to newsletter')
    .value('1');

document.getElementById('container').innerHTML = newsletter.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<label class="so-checkbox">
    <input type="checkbox" name="newsletter" value="1">
    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
    <span class="so-checkbox-label">Subscribe to newsletter</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Help Text -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Help Text</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <label class="so-checkbox">
                    <input type="checkbox" name="marketing">
                    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                    <span class="so-checkbox-label">Enable marketing emails</span>
                </label>
                <div class="so-form-text">You can unsubscribe at any time from your account settings.</div>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-help', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$checkbox = UiEngine::checkbox('marketing')
    ->label('Enable marketing emails')
    ->help('You can unsubscribe at any time from your account settings.');

echo \$checkbox->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const checkbox = UiEngine.checkbox('marketing')
    .label('Enable marketing emails')
    .help('You can unsubscribe at any time from your account settings.');

document.getElementById('container').innerHTML = checkbox.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<label class="so-checkbox">
    <input type="checkbox" name="marketing">
    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
    <span class="so-checkbox-label">Enable marketing emails</span>
</label>
<div class="so-form-text">You can unsubscribe at any time from your account settings.</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Error State -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Error State</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <label class="so-checkbox so-is-invalid">
                    <input type="checkbox" name="agreement" class="so-is-invalid">
                    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                    <span class="so-checkbox-label">I accept the terms and conditions</span>
                </label>
                <div class="so-invalid-feedback so-d-block">You must accept the terms and conditions to proceed.</div>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-error', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$checkbox = UiEngine::checkbox('agreement')
    ->label('I accept the terms and conditions')
    ->required()
    ->error('You must accept the terms and conditions to proceed.');

echo \$checkbox->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const checkbox = UiEngine.checkbox('agreement')
    .label('I accept the terms and conditions')
    .required()
    .error('You must accept the terms and conditions to proceed.');

document.getElementById('container').innerHTML = checkbox.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<label class="so-checkbox so-is-invalid">
    <input type="checkbox" name="agreement" required class="so-is-invalid">
    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
    <span class="so-checkbox-label">I accept the terms and conditions</span>
</label>
<div class="so-invalid-feedback so-d-block">You must accept the terms and conditions to proceed.</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Pre-selected Options in Groups -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Pre-selected Options</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Pre-select options when loading data from database or setting defaults.</p>

                <!-- Live Demo -->
                <label class="so-form-label so-mb-2">Selected permissions</label>
                <div class="so-checkbox-group so-checkbox-group-vertical">
                    <label class="so-checkbox">
                        <input type="checkbox" name="permissions[]" value="read" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Read</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" name="permissions[]" value="write" checked>
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Write</span>
                    </label>
                    <label class="so-checkbox">
                        <input type="checkbox" name="permissions[]" value="delete">
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Delete</span>
                    </label>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-preselected', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Method 1: Using value() with array of selected values
\$selectedPermissions = ['read', 'write']; // From database

\$permissions = UiEngine::checkbox('permissions')
    ->label('Selected permissions')
    ->options([
        'read' => 'Read',
        'write' => 'Write',
        'delete' => 'Delete',
    ])
    ->value(\$selectedPermissions);  // Pre-select matching options

echo \$permissions->render();

// Method 2: Using option() with individual checked states
\$permissions = UiEngine::checkbox('permissions')
    ->label('Selected permissions')
    ->option('read', 'Read', true)      // Pre-checked
    ->option('write', 'Write', true)    // Pre-checked
    ->option('delete', 'Delete', false); // Not checked

echo \$permissions->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Pre-select based on data
const selectedPermissions = ['read', 'write'];

const permissions = UiEngine.checkbox('permissions')
    .label('Selected permissions')
    .options({
        read: 'Read',
        write: 'Write',
        delete: 'Delete',
    })
    .value(selectedPermissions);

document.getElementById('container').innerHTML = permissions.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label so-mb-2">Selected permissions</label>
    <div class="so-checkbox-group so-checkbox-group-vertical">
        <label class="so-checkbox">
            <input type="checkbox" name="permissions[]" value="read" checked>
            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
            <span class="so-checkbox-label">Read</span>
        </label>
        <label class="so-checkbox">
            <input type="checkbox" name="permissions[]" value="write" checked>
            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
            <span class="so-checkbox-label">Write</span>
        </label>
        <label class="so-checkbox">
            <input type="checkbox" name="permissions[]" value="delete">
            <span class="so-checkbox-box"><span class="material-icons">check</span></span>
            <span class="so-checkbox-label">Delete</span>
        </label>
    </div>
</div>'
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
                <p class="so-text-muted so-mb-3">Checkboxes use native DOM events and can be manipulated via standard JavaScript. No dedicated JS component is required as styling is CSS-based.</p>

                <!-- Live Demo -->
                <div class="so-mb-3">
                    <label class="so-checkbox" id="demo-checkbox-js">
                        <input type="checkbox" name="demo_js">
                        <span class="so-checkbox-box"><span class="material-icons">check</span></span>
                        <span class="so-checkbox-label">Toggle me</span>
                    </label>
                </div>
                <div class="so-d-flex so-gap-2 so-mb-3">
                    <button class="so-btn so-btn-primary so-btn-sm" onclick="document.querySelector('#demo-checkbox-js input').checked = true;">Check</button>
                    <button class="so-btn so-btn-secondary so-btn-sm" onclick="document.querySelector('#demo-checkbox-js input').checked = false;">Uncheck</button>
                    <button class="so-btn so-btn-outline-primary so-btn-sm" onclick="document.querySelector('#demo-checkbox-js input').click();">Toggle</button>
                    <button class="so-btn so-btn-outline-secondary so-btn-sm" onclick="document.querySelector('#demo-checkbox-js input').disabled = !document.querySelector('#demo-checkbox-js input').disabled; document.querySelector('#demo-checkbox-js').classList.toggle('so-disabled');">Toggle Disabled</button>
                </div>
                <div id="checkbox-event-output" class="so-alert so-alert-info">Interact with the checkbox to see events.</div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const demoInput = document.querySelector('#demo-checkbox-js input');
                        const output = document.getElementById('checkbox-event-output');

                        demoInput.addEventListener('change', function(e) {
                            output.textContent = `change event: checked = ${e.target.checked}`;
                        });

                        demoInput.addEventListener('click', function(e) {
                            output.textContent = `click event fired (checked will be: ${!e.target.checked})`;
                        });
                    });
                </script>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-js-interactivity', [
                    [
                        'label' => 'Getting Values',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Get single checkbox value
const checkbox = document.querySelector('input[name=\"terms\"]');
const isChecked = checkbox.checked;  // true or false
const value = checkbox.value;        // The value attribute

// Get all checked values from a group
const checkedValues = [...document.querySelectorAll('input[name=\"interests[]\"]:checked')]
    .map(cb => cb.value);
// Result: ['tech', 'sports'] if those are checked

// Check if at least one is selected
const hasSelection = document.querySelectorAll('input[name=\"interests[]\"]:checked').length > 0;"
                    ],
                    [
                        'label' => 'Setting Values',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Check/uncheck a single checkbox
const checkbox = document.querySelector('input[name=\"terms\"]');
checkbox.checked = true;   // Check
checkbox.checked = false;  // Uncheck

// Toggle checkbox state
checkbox.checked = !checkbox.checked;

// Set multiple checkboxes in a group
const selectedValues = ['tech', 'music'];
document.querySelectorAll('input[name=\"interests[]\"]').forEach(cb => {
    cb.checked = selectedValues.includes(cb.value);
});

// Check all checkboxes in a group
document.querySelectorAll('input[name=\"interests[]\"]').forEach(cb => {
    cb.checked = true;
});

// Uncheck all
document.querySelectorAll('input[name=\"interests[]\"]').forEach(cb => {
    cb.checked = false;
});"
                    ],
                    [
                        'label' => 'Event Handling',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Listen for change event
const checkbox = document.querySelector('input[name=\"terms\"]');
checkbox.addEventListener('change', function(e) {
    console.log('Checkbox changed:', e.target.checked);

    if (e.target.checked) {
        console.log('Checkbox was checked');
    } else {
        console.log('Checkbox was unchecked');
    }
});

// Using event delegation for dynamic checkboxes
document.addEventListener('change', function(e) {
    if (e.target.matches('.so-checkbox input[type=\"checkbox\"]')) {
        console.log('A SixOrbit checkbox changed:', e.target.name, e.target.checked);
    }
});

// Listen for multiple checkboxes
document.querySelectorAll('input[name=\"interests[]\"]').forEach(cb => {
    cb.addEventListener('change', function(e) {
        const checkedCount = document.querySelectorAll('input[name=\"interests[]\"]:checked').length;
        console.log(\`\${checkedCount} items selected\`);
    });
});"
                    ],
                    [
                        'label' => 'States & Attributes',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const checkbox = document.querySelector('input[name=\"terms\"]');
const label = checkbox.closest('.so-checkbox');

// Enable/disable
checkbox.disabled = true;
label.classList.add('so-disabled');

checkbox.disabled = false;
label.classList.remove('so-disabled');

// Set indeterminate state
checkbox.indeterminate = true;
// Update icon for visual feedback
label.querySelector('.so-checkbox-box .material-icons').textContent = 'remove';

// Clear indeterminate
checkbox.indeterminate = false;
label.querySelector('.so-checkbox-box .material-icons').textContent = 'check';

// Required attribute
checkbox.required = true;
checkbox.required = false;

// Add error state
label.classList.add('so-is-invalid');
checkbox.classList.add('so-is-invalid');

// Remove error state
label.classList.remove('so-is-invalid');
checkbox.classList.remove('so-is-invalid');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- PHP Event Handlers -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP Event Handlers</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Set JavaScript event handlers from PHP using the HasEvents trait methods.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-php-events', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Set individual event handlers
\$checkbox = UiEngine::checkbox('terms')
    ->label('I accept the terms')
    ->onChange('handleTermsChange(this)')
    ->onClick('trackClick(event)');

// Set multiple events at once
\$checkbox = UiEngine::checkbox('newsletter')
    ->label('Subscribe to newsletter')
    ->onMany([
        'change' => 'handleNewsletterChange(this)',
        'focus' => 'trackFocus()',
        'blur' => 'trackBlur()',
    ]);

// Use inline event handlers (onclick=, onchange=, etc.)
\$checkbox = UiEngine::checkbox('notification')
    ->label('Enable notifications')
    ->useInlineEvents(true)
    ->onChange('this.form.submit()');

// Available event methods from HasEvents trait:
// ->on('event', 'handler')      - Generic event handler
// ->onClick('handler')          - Click event
// ->onChange('handler')         - Change event
// ->onFocus('handler')          - Focus event
// ->onBlur('handler')           - Blur event
// ->onKeyUp('handler')          - Key up event
// ->onKeyDown('handler')        - Key down event
// ->onMouseEnter('handler')     - Mouse enter event
// ->onMouseLeave('handler')     - Mouse leave event
// ->onHover('enter', 'leave')   - Hover events (enter and leave)"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- With data attributes (default) -->
<label class="so-checkbox">
    <input type="checkbox" name="terms"
           data-on-change="handleTermsChange(this)"
           data-on-click="trackClick(event)">
    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
    <span class="so-checkbox-label">I accept the terms</span>
</label>

<!-- With inline events (useInlineEvents(true)) -->
<label class="so-checkbox">
    <input type="checkbox" name="notification"
           onchange="this.form.submit()">
    <span class="so-checkbox-box"><span class="material-icons">check</span></span>
    <span class="so-checkbox-label">Enable notifications</span>
</label>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Validation -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Checkbox elements support validation through the HasValidation trait. Rules can be exported to JavaScript for client-side validation.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-validation', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Required checkbox (must be checked)
\$terms = UiEngine::checkbox('terms')
    ->label('I agree to the terms and conditions')
    ->required('You must accept the terms');

// Using rules() method
\$privacy = UiEngine::checkbox('privacy')
    ->label('I have read the privacy policy')
    ->rules('required|accepted');

// Custom validation messages
\$newsletter = UiEngine::checkbox('newsletter')
    ->label('Subscribe to newsletter')
    ->required()
    ->message('required', 'Please indicate your newsletter preference');

// For checkbox groups - require at least one selection
\$interests = UiEngine::checkbox('interests')
    ->label('Select at least one interest')
    ->options([
        'tech' => 'Technology',
        'sports' => 'Sports',
        'music' => 'Music',
    ])
    ->required('Please select at least one interest');

// Export validation for JavaScript
\$validation = \$terms->exportValidation();
// Returns: ['rules' => ['required' => true], 'messages' => ['required' => 'You must accept the terms']]"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Client-side validation
function validateCheckbox(checkbox) {
    const isRequired = checkbox.hasAttribute('required');
    const isChecked = checkbox.checked;
    const label = checkbox.closest('.so-checkbox');

    // Clear previous error state
    label.classList.remove('so-is-invalid');
    const errorEl = label.parentNode.querySelector('.so-invalid-feedback');
    if (errorEl) errorEl.remove();

    // Validate
    if (isRequired && !isChecked) {
        label.classList.add('so-is-invalid');

        const error = document.createElement('div');
        error.className = 'so-invalid-feedback so-d-block';
        error.textContent = checkbox.dataset.errorMessage || 'This field is required';
        label.parentNode.appendChild(error);

        return false;
    }

    return true;
}

// Validate checkbox group (at least one checked)
function validateCheckboxGroup(name, minRequired = 1) {
    const checkboxes = document.querySelectorAll(\`input[name=\"\${name}[]\"]\`);
    const checkedCount = [...checkboxes].filter(cb => cb.checked).length;

    return checkedCount >= minRequired;
}

// Example usage
const termsCheckbox = document.querySelector('input[name=\"terms\"]');
termsCheckbox.addEventListener('change', () => {
    validateCheckbox(termsCheckbox);
});

// Form submission validation
document.querySelector('form').addEventListener('submit', function(e) {
    if (!validateCheckbox(termsCheckbox)) {
        e.preventDefault();
    }
});"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Error Handling -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Error Handling</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Display validation errors and handle error states on checkbox elements.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-error-handling', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Set error message from server-side validation
\$checkbox = UiEngine::checkbox('terms')
    ->label('I agree to the terms')
    ->error('You must accept the terms before continuing');

// Check for errors
if (\$checkbox->hasError()) {
    \$errorMessage = \$checkbox->getError();
}

// Clear error
\$checkbox->error(null);

// Display with errors from validator
\$errors = \$validator->errors();
\$checkbox = UiEngine::checkbox('terms')
    ->label('I agree to the terms')
    ->error(\$errors->first('terms'));  // Get first error for field

// Conditional error based on validation result
\$checkbox = UiEngine::checkbox('agreement')
    ->label('I accept')
    ->when(\$hasError, fn(\$cb) => \$cb->error('Acceptance required'));"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Show error state
function showCheckboxError(checkbox, message) {
    const label = checkbox.closest('.so-checkbox');

    // Add error classes
    label.classList.add('so-is-invalid');
    checkbox.classList.add('so-is-invalid');

    // Remove existing error message
    const existingError = label.parentNode.querySelector('.so-invalid-feedback');
    if (existingError) existingError.remove();

    // Add error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'so-invalid-feedback so-d-block';
    errorDiv.textContent = message;
    label.parentNode.appendChild(errorDiv);
}

// Clear error state
function clearCheckboxError(checkbox) {
    const label = checkbox.closest('.so-checkbox');

    // Remove error classes
    label.classList.remove('so-is-invalid');
    checkbox.classList.remove('so-is-invalid');

    // Remove error message
    const errorDiv = label.parentNode.querySelector('.so-invalid-feedback');
    if (errorDiv) errorDiv.remove();
}

// Handle server-side validation errors
async function submitForm(form) {
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form)
        });

        if (!response.ok) {
            const data = await response.json();

            // Display errors
            Object.entries(data.errors || {}).forEach(([field, messages]) => {
                const checkbox = form.querySelector(\`input[name=\"\${field}\"]\`);
                if (checkbox && checkbox.type === 'checkbox') {
                    showCheckboxError(checkbox, messages[0]);
                }
            });
        }
    } catch (error) {
        console.error('Form submission failed:', error);
    }
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- PHP to JS Configuration -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP to JavaScript Configuration</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Export checkbox configuration from PHP for JavaScript consumption.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('checkbox-php-js', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Create checkbox with full configuration
\$checkbox = UiEngine::checkbox('notifications')
    ->id('notifications-checkbox')
    ->label('Enable notifications')
    ->value('1')
    ->checked(true)
    ->help('Receive push notifications for important updates')
    ->required()
    ->data('category', 'settings')
    ->data('track', 'true');

// Export to array for JSON
\$config = \$checkbox->toArray();
/*
Returns:
[
    'type' => 'checkbox',
    'id' => 'notifications-checkbox',
    'name' => 'notifications',
    'label' => 'Enable notifications',
    'value' => '1',
    'checked' => true,
    'help' => 'Receive push notifications for important updates',
    'required' => true,
    'data' => [
        'category' => 'settings',
        'track' => 'true'
    ]
]
*/

// Pass to JavaScript
echo '<script>window.checkboxConfig = ' . json_encode(\$config) . ';</script>';

// Or embed in data attribute
echo '<div data-checkbox-config=\"' . e(json_encode(\$config)) . '\"></div>';"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Access configuration from window
const config = window.checkboxConfig;
console.log(config.name);     // 'notifications'
console.log(config.checked);  // true
console.log(config.required); // true

// Access from data attribute
const container = document.querySelector('[data-checkbox-config]');
const config2 = JSON.parse(container.dataset.checkboxConfig);

// Initialize checkbox from config
function initCheckboxFromConfig(config, targetEl) {
    const checkbox = targetEl.querySelector(\`input[name=\"\${config.name}\"]\`);
    if (!checkbox) return;

    // Apply configuration
    if (config.checked) checkbox.checked = true;
    if (config.disabled) checkbox.disabled = true;
    if (config.required) checkbox.required = true;

    // Apply data attributes
    if (config.data) {
        Object.entries(config.data).forEach(([key, value]) => {
            checkbox.dataset[key] = value;
        });
    }
}

// Get validation config
const validation = {
    rules: config.rules || {},
    messages: config.messages || {}
};

// Example: Dynamic checkbox group from server config
function renderCheckboxGroup(options, containerEl) {
    options.forEach(opt => {
        const label = document.createElement('label');
        label.className = 'so-checkbox';
        label.innerHTML = \`
            <input type=\"checkbox\" name=\"\${opt.name}\" value=\"\${opt.value}\" \${opt.checked ? 'checked' : ''}>
            <span class=\"so-checkbox-box\"><span class=\"material-icons\">check</span></span>
            <span class=\"so-checkbox-label\">\${opt.label}</span>
        \`;
        containerEl.appendChild(label);
    });
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>so-checkbox</code></td>
                                <td>Main wrapper class for single checkbox. Applied to the <code>&lt;label&gt;</code> element.</td>
                            </tr>
                            <tr>
                                <td><code>so-checkbox-box</code></td>
                                <td>The visual checkbox indicator container. Contains the check icon.</td>
                            </tr>
                            <tr>
                                <td><code>so-checkbox-label</code></td>
                                <td>The text label for the checkbox.</td>
                            </tr>
                            <tr>
                                <td><code>so-checkbox-group</code></td>
                                <td>Wrapper for multiple checkboxes in a group.</td>
                            </tr>
                            <tr>
                                <td><code>so-checkbox-group-vertical</code></td>
                                <td>Display checkbox group items vertically (stacked). This is the default.</td>
                            </tr>
                            <tr>
                                <td><code>so-checkbox-group-inline</code></td>
                                <td>Display checkbox group items horizontally (inline).</td>
                            </tr>
                            <tr>
                                <td><code>so-disabled</code></td>
                                <td>Applied to checkbox label when disabled. Reduces opacity and prevents interaction.</td>
                            </tr>
                            <tr>
                                <td><code>so-is-invalid</code></td>
                                <td>Error state class. Applied to both label and input for validation errors.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-group</code></td>
                                <td>Wrapper for form field with label, help text, and error message.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-label</code></td>
                                <td>Group label styling for checkbox groups.</td>
                            </tr>
                            <tr>
                                <td><code>so-form-text</code></td>
                                <td>Help text styling.</td>
                            </tr>
                            <tr>
                                <td><code>so-invalid-feedback</code></td>
                                <td>Error message styling. Use with <code>so-d-block</code> to display.</td>
                            </tr>
                            <tr>
                                <td><code>so-text-danger</code></td>
                                <td>Red color for required field indicators (*)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <!-- Tabs Navigation -->
                <div class="so-tabs so-mb-3" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#checkbox-methods">Checkbox Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#form-methods">Form Element</button>
                    <button class="so-tab" role="tab" data-so-target="#validation-methods">Validation</button>
                    <button class="so-tab" role="tab" data-so-target="#event-methods">Events</button>
                    <button class="so-tab" role="tab" data-so-target="#base-methods">Base Element</button>
                </div>

                <!-- Tab Panes -->
                <div class="so-tab-content">
                    <!-- Checkbox Methods -->
                    <div class="so-tab-pane so-fade so-show so-active" id="checkbox-methods">
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Method</th>
                                        <th>Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>checked()</code></td>
                                        <td><code>bool $checked = true</code></td>
                                        <td>Set the checkbox as checked</td>
                                    </tr>
                                    <tr>
                                        <td><code>unchecked()</code></td>
                                        <td>-</td>
                                        <td>Set the checkbox as unchecked</td>
                                    </tr>
                                    <tr>
                                        <td><code>options()</code></td>
                                        <td><code>array $options</code></td>
                                        <td>Set options for checkbox group (value => label pairs)</td>
                                    </tr>
                                    <tr>
                                        <td><code>option()</code></td>
                                        <td><code>string|int $value, string $label, bool $checked = false</code></td>
                                        <td>Add a single option to the group</td>
                                    </tr>
                                    <tr>
                                        <td><code>inline()</code></td>
                                        <td><code>bool $inline = true</code></td>
                                        <td>Display checkboxes inline horizontally</td>
                                    </tr>
                                    <tr>
                                        <td><code>switch()</code></td>
                                        <td><code>bool $switch = true</code></td>
                                        <td>Use switch toggle style (CSS-based)</td>
                                    </tr>
                                    <tr>
                                        <td><code>indeterminate()</code></td>
                                        <td><code>bool $indeterminate = true</code></td>
                                        <td>Set indeterminate state (adds data attribute for JS)</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>-</td>
                                        <td>Render the checkbox HTML (auto-detects single vs group)</td>
                                    </tr>
                                    <tr>
                                        <td><code>renderGroup()</code></td>
                                        <td>-</td>
                                        <td>Render as a form group with wrapper</td>
                                    </tr>
                                    <tr>
                                        <td><code>toArray()</code></td>
                                        <td>-</td>
                                        <td>Export checkbox configuration as array</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Form Element Methods -->
                    <div class="so-tab-pane so-fade" id="form-methods">
                        <p class="so-text-muted so-mb-2">Inherited from <code>FormElement</code> class:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Method</th>
                                        <th>Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>name()</code></td>
                                        <td><code>string $name</code></td>
                                        <td>Set the field name attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>label()</code></td>
                                        <td><code>string $label</code></td>
                                        <td>Set the label text</td>
                                    </tr>
                                    <tr>
                                        <td><code>value()</code></td>
                                        <td><code>mixed $value</code></td>
                                        <td>Set the field value (array for pre-selected options)</td>
                                    </tr>
                                    <tr>
                                        <td><code>help()</code></td>
                                        <td><code>string $help</code></td>
                                        <td>Set help text displayed below the field</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled()</code></td>
                                        <td><code>bool $disabled = true</code></td>
                                        <td>Disable the checkbox</td>
                                    </tr>
                                    <tr>
                                        <td><code>readonly()</code></td>
                                        <td><code>bool $readonly = true</code></td>
                                        <td>Set readonly state (limited for checkboxes)</td>
                                    </tr>
                                    <tr>
                                        <td><code>error()</code></td>
                                        <td><code>?string $error</code></td>
                                        <td>Set error message</td>
                                    </tr>
                                    <tr>
                                        <td><code>hasError()</code></td>
                                        <td>-</td>
                                        <td>Check if field has an error</td>
                                    </tr>
                                    <tr>
                                        <td><code>getError()</code></td>
                                        <td>-</td>
                                        <td>Get the error message</td>
                                    </tr>
                                    <tr>
                                        <td><code>showLabel()</code></td>
                                        <td><code>bool $show = true</code></td>
                                        <td>Toggle label visibility</td>
                                    </tr>
                                    <tr>
                                        <td><code>hideLabel()</code></td>
                                        <td>-</td>
                                        <td>Hide the label</td>
                                    </tr>
                                    <tr>
                                        <td><code>size()</code></td>
                                        <td><code>string $size</code></td>
                                        <td>Set size variant (sm, md, lg)</td>
                                    </tr>
                                    <tr>
                                        <td><code>small()</code></td>
                                        <td>-</td>
                                        <td>Set small size</td>
                                    </tr>
                                    <tr>
                                        <td><code>large()</code></td>
                                        <td>-</td>
                                        <td>Set large size</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Validation Methods -->
                    <div class="so-tab-pane so-fade" id="validation-methods">
                        <p class="so-text-muted so-mb-2">From <code>HasValidation</code> trait:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Method</th>
                                        <th>Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>rules()</code></td>
                                        <td><code>string|array $rules</code></td>
                                        <td>Set validation rules (pipe-separated string or array)</td>
                                    </tr>
                                    <tr>
                                        <td><code>addRule()</code></td>
                                        <td><code>string $rule, mixed $params = true</code></td>
                                        <td>Add a single validation rule</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeRule()</code></td>
                                        <td><code>string $rule</code></td>
                                        <td>Remove a validation rule</td>
                                    </tr>
                                    <tr>
                                        <td><code>hasRule()</code></td>
                                        <td><code>string $rule</code></td>
                                        <td>Check if a rule exists</td>
                                    </tr>
                                    <tr>
                                        <td><code>getRules()</code></td>
                                        <td>-</td>
                                        <td>Get all validation rules</td>
                                    </tr>
                                    <tr>
                                        <td><code>clearRules()</code></td>
                                        <td>-</td>
                                        <td>Clear all validation rules</td>
                                    </tr>
                                    <tr>
                                        <td><code>messages()</code></td>
                                        <td><code>array $messages</code></td>
                                        <td>Set custom error messages for rules</td>
                                    </tr>
                                    <tr>
                                        <td><code>message()</code></td>
                                        <td><code>string $rule, string $message</code></td>
                                        <td>Set a single custom error message</td>
                                    </tr>
                                    <tr>
                                        <td><code>required()</code></td>
                                        <td><code>?string $message = null</code></td>
                                        <td>Add required rule with optional message</td>
                                    </tr>
                                    <tr>
                                        <td><code>min()</code></td>
                                        <td><code>int $min, ?string $message = null</code></td>
                                        <td>Add minimum selections rule</td>
                                    </tr>
                                    <tr>
                                        <td><code>max()</code></td>
                                        <td><code>int $max, ?string $message = null</code></td>
                                        <td>Add maximum selections rule</td>
                                    </tr>
                                    <tr>
                                        <td><code>exportValidation()</code></td>
                                        <td>-</td>
                                        <td>Export rules and messages for JavaScript</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Event Methods -->
                    <div class="so-tab-pane so-fade" id="event-methods">
                        <p class="so-text-muted so-mb-2">From <code>HasEvents</code> trait:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Method</th>
                                        <th>Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>on()</code></td>
                                        <td><code>string $event, string $handler</code></td>
                                        <td>Set an event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onMany()</code></td>
                                        <td><code>array $events</code></td>
                                        <td>Set multiple event handlers</td>
                                    </tr>
                                    <tr>
                                        <td><code>off()</code></td>
                                        <td><code>string $event</code></td>
                                        <td>Remove an event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onClick()</code></td>
                                        <td><code>string $handler</code></td>
                                        <td>Set click event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onChange()</code></td>
                                        <td><code>string $handler</code></td>
                                        <td>Set change event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onFocus()</code></td>
                                        <td><code>string $handler</code></td>
                                        <td>Set focus event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onBlur()</code></td>
                                        <td><code>string $handler</code></td>
                                        <td>Set blur event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onKeyUp()</code></td>
                                        <td><code>string $handler</code></td>
                                        <td>Set keyup event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>onKeyDown()</code></td>
                                        <td><code>string $handler</code></td>
                                        <td>Set keydown event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>useInlineEvents()</code></td>
                                        <td><code>bool $inline = true</code></td>
                                        <td>Use inline handlers (onclick=) vs data attributes</td>
                                    </tr>
                                    <tr>
                                        <td><code>clearEvents()</code></td>
                                        <td>-</td>
                                        <td>Clear all event handlers</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Base Element Methods -->
                    <div class="so-tab-pane so-fade" id="base-methods">
                        <p class="so-text-muted so-mb-2">Inherited from <code>Element</code> base class:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th>Method</th>
                                        <th>Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>id()</code></td>
                                        <td><code>string $id</code></td>
                                        <td>Set the element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>getId()</code></td>
                                        <td>-</td>
                                        <td>Get the element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>class()</code></td>
                                        <td><code>string $class</code></td>
                                        <td>Add CSS class(es)</td>
                                    </tr>
                                    <tr>
                                        <td><code>addClass()</code></td>
                                        <td><code>string $class</code></td>
                                        <td>Add a CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeClass()</code></td>
                                        <td><code>string $class</code></td>
                                        <td>Remove a CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr()</code></td>
                                        <td><code>string $name, mixed $value = null</code></td>
                                        <td>Set an HTML attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>setAttributes()</code></td>
                                        <td><code>array $attrs</code></td>
                                        <td>Set multiple HTML attributes</td>
                                    </tr>
                                    <tr>
                                        <td><code>data()</code></td>
                                        <td><code>string $key, mixed $value</code></td>
                                        <td>Set a data attribute (data-*)</td>
                                    </tr>
                                    <tr>
                                        <td><code>setDataAttributes()</code></td>
                                        <td><code>array $data</code></td>
                                        <td>Set multiple data attributes</td>
                                    </tr>
                                    <tr>
                                        <td><code>when()</code></td>
                                        <td><code>bool $condition, callable $callback, ?callable $fallback = null</code></td>
                                        <td>Conditional method chaining</td>
                                    </tr>
                                    <tr>
                                        <td><code>unless()</code></td>
                                        <td><code>bool $condition, callable $callback</code></td>
                                        <td>Inverse conditional method chaining</td>
                                    </tr>
                                    <tr>
                                        <td><code>getType()</code></td>
                                        <td>-</td>
                                        <td>Get element type identifier</td>
                                    </tr>
                                    <tr>
                                        <td><code>getConfig()</code></td>
                                        <td>-</td>
                                        <td>Get original configuration array</td>
                                    </tr>
                                    <tr>
                                        <td><code>clone()</code></td>
                                        <td>-</td>
                                        <td>Clone the element</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
