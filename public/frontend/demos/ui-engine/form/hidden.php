<?php
/**
 * SixOrbit UI Engine - Hidden Element Demo
 */

$pageTitle = 'Hidden - UI Engine';
$pageDescription = 'Hidden input for form data not visible to users';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Hidden</h1>
            <p class="so-page-subtitle">Hidden input element for storing data that should be submitted with the form but not visible to users.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Hidden Input -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Hidden Input</h3>
            </div>
            <div class="so-card-body">
                <!-- Info -->
                <div class="so-alert so-alert-info so-mb-4">
                    <span class="material-icons">info</span>
                    <div>Hidden inputs are not visible on the page. They store data that should be submitted with the form but not displayed or edited by users.</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-hidden', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$hidden = UiEngine::hidden('user_id')
    ->value('12345');

echo \$hidden->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const hidden = UiEngine.hidden('user_id')
    .setValue('12345');

document.getElementById('form').appendChild(hidden.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<input type="hidden" name="user_id" value="12345">'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Common Use Cases -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Common Use Cases</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Hidden inputs are essential for passing data that shouldn't be visible or editable by users.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('hidden-usecases', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// CSRF Token Protection
UiEngine::hidden('_token')->value(\$csrfToken);

// Record ID for Edit Forms
UiEngine::hidden('id')->value(\$record->id);

// HTTP Method Override (PUT, PATCH, DELETE)
UiEngine::hidden('_method')->value('PUT');

// Form Action Context
UiEngine::hidden('action')->value('update');

// Tracking/Referral Data
UiEngine::hidden('ref')->value(\$_GET['ref'] ?? '');

// Parent/Foreign Key References
UiEngine::hidden('category_id')->value(\$category->id);

// Timestamp for Optimistic Locking
UiEngine::hidden('updated_at')->value(\$record->updated_at);

// JSON Encoded Data
UiEngine::hidden('metadata')
    ->value(json_encode(['source' => 'web', 'version' => '1.0']));"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// CSRF Token
UiEngine.hidden('_token').setValue(csrfToken);

// Record ID for editing
UiEngine.hidden('id').setValue(record.id);

// HTTP Method Override
UiEngine.hidden('_method').setValue('PUT');

// Store complex data as JSON
const metadata = UiEngine.hidden('metadata');
metadata.setValue(JSON.stringify({
    items: selectedItems,
    timestamp: Date.now(),
    source: 'client'
}));

// Tracking data from URL params
const urlParams = new URLSearchParams(window.location.search);
UiEngine.hidden('utm_source').setValue(urlParams.get('utm_source') || '');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- CSRF Token -->
<input type="hidden" name="_token" value="abc123xyz">

<!-- Record ID -->
<input type="hidden" name="id" value="12345">

<!-- HTTP Method Override -->
<input type="hidden" name="_method" value="PUT">

<!-- Form action context -->
<input type="hidden" name="action" value="update">

<!-- JSON data -->
<input type="hidden" name="metadata" value="{&quot;source&quot;:&quot;web&quot;}">'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- In Form Context -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">In Form Context</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <form class="so-mb-4" id="demo-form">
                    <input type="hidden" name="user_id" value="12345">
                    <input type="hidden" name="_token" value="abc123xyz">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="so-form-group so-mb-3">
                        <label class="so-form-label" for="demo-name">Name</label>
                        <input type="text" class="so-form-control" id="demo-name" name="name" value="John Doe">
                    </div>
                    <div class="so-form-group so-mb-3">
                        <label class="so-form-label" for="demo-email">Email</label>
                        <input type="email" class="so-form-control" id="demo-email" name="email" value="john@example.com">
                    </div>
                    <button type="button" class="so-btn so-btn-primary" onclick="showHiddenFields()">Show Hidden Fields</button>
                </form>
                <div id="hidden-fields-display" class="so-p-3 so-bg-dark so-text-white so-rounded" style="display:none;">
                    <small><strong>Hidden fields in this form:</strong></small>
                    <pre class="so-mb-0 so-mt-2 so-text-white" id="hidden-values"></pre>
                </div>

                <script>
                function showHiddenFields() {
                    const form = document.getElementById('demo-form');
                    const hiddenInputs = form.querySelectorAll('input[type="hidden"]');
                    const display = document.getElementById('hidden-fields-display');
                    const values = document.getElementById('hidden-values');

                    let output = '';
                    hiddenInputs.forEach(input => {
                        output += `${input.name} = "${input.value}"\n`;
                    });

                    values.textContent = output;
                    display.style.display = 'block';
                }
                </script>

                <!-- Code Tabs -->
                <?= so_code_tabs('hidden-form', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Building a complete edit form with hidden fields
\$form = UiEngine::form('/users/' . \$user->id)
    ->put()  // Sets method to POST with _method=PUT override
    ->csrf(\$csrfToken)  // Adds CSRF token hidden field
    ->add(UiEngine::hidden('id')->value(\$user->id))
    ->add(UiEngine::input('name')
        ->label('Name')
        ->value(\$user->name)
        ->required())
    ->add(UiEngine::email('email')
        ->label('Email')
        ->value(\$user->email)
        ->required())
    ->add(UiEngine::button('Update Profile')
        ->type('submit')
        ->variant('primary'));

echo \$form->render();

// Alternative: Add hidden fields individually
echo UiEngine::hidden('user_id')->value(\$user->id)->render();
echo UiEngine::hidden('_token')->value(\$csrfToken)->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Building a form with hidden fields
const form = UiEngine.form('/users/update')
    .method('PUT')
    .add(UiEngine.hidden('id').setValue(user.id))
    .add(UiEngine.hidden('_token').setValue(csrfToken))
    .add(UiEngine.input('name')
        .setLabel('Name')
        .setValue(user.name)
        .required())
    .add(UiEngine.email('email')
        .setLabel('Email')
        .setValue(user.email)
        .required())
    .add(UiEngine.button('Update Profile')
        .type('submit')
        .variant('primary'));

document.getElementById('container').appendChild(form.render());

// Dynamically adding hidden fields to existing form
const existingForm = document.getElementById('my-form');
const hiddenField = UiEngine.hidden('tracking_id')
    .setValue('track_123')
    .render();
existingForm.appendChild(hiddenField);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<form action="/users/123" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="abc123xyz">
    <input type="hidden" name="id" value="123">

    <div class="so-form-group">
        <label class="so-form-label" for="name">Name <span class="so-text-danger">*</span></label>
        <input type="text" class="so-form-control" id="name" name="name" value="John Doe" required>
    </div>
    <div class="so-form-group">
        <label class="so-form-label" for="email">Email <span class="so-text-danger">*</span></label>
        <input type="email" class="so-form-control" id="email" name="email" value="john@example.com" required>
    </div>
    <button type="submit" class="so-btn so-btn-primary">Update Profile</button>
</form>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Custom Attributes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Custom Attributes</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-3">Add custom HTML attributes and data attributes to hidden inputs.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('hidden-attributes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// With ID for JavaScript access
\$hidden = UiEngine::hidden('selected_items')
    ->id('selected-items-input')
    ->value('[]');

// With data attributes
\$hidden = UiEngine::hidden('config')
    ->id('config-input')
    ->data('type', 'json')
    ->data('auto-update', 'true')
    ->value(json_encode(\$config));

// With custom attributes
\$hidden = UiEngine::hidden('signature')
    ->attr('data-encrypted', 'true')
    ->attr('data-algorithm', 'sha256')
    ->value(\$signature);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// With ID for easy access
const hidden = UiEngine.hidden('selected_items')
    .setId('selected-items-input')
    .setValue('[]');

// With data attributes
const configHidden = UiEngine.hidden('config')
    .setId('config-input')
    .setData('type', 'json')
    .setData('autoUpdate', 'true')
    .setValue(JSON.stringify(config));

// With custom attributes
const signatureHidden = UiEngine.hidden('signature')
    .setAttr('data-encrypted', 'true')
    .setAttr('data-algorithm', 'sha256')
    .setValue(signature);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- With ID -->
<input type="hidden" id="selected-items-input" name="selected_items" value="[]">

<!-- With data attributes -->
<input type="hidden" id="config-input" name="config"
       data-type="json" data-auto-update="true"
       value="{&quot;key&quot;:&quot;value&quot;}">

<!-- With custom attributes -->
<input type="hidden" name="signature"
       data-encrypted="true" data-algorithm="sha256"
       value="abc123...">'
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
                <p class="so-text-muted so-mb-3">Hidden inputs are often manipulated via JavaScript to store dynamic data before form submission.</p>

                <!-- Live Demo -->
                <div class="so-mb-4">
                    <div class="so-form-group so-mb-3">
                        <label class="so-form-label">Select items to add:</label>
                        <div class="so-d-flex so-gap-2 so-flex-wrap">
                            <button type="button" class="so-btn so-btn-outline-primary so-btn-sm" onclick="addItem('apple')">Apple</button>
                            <button type="button" class="so-btn so-btn-outline-primary so-btn-sm" onclick="addItem('banana')">Banana</button>
                            <button type="button" class="so-btn so-btn-outline-primary so-btn-sm" onclick="addItem('orange')">Orange</button>
                            <button type="button" class="so-btn so-btn-outline-secondary so-btn-sm" onclick="clearItems()">Clear All</button>
                        </div>
                    </div>
                    <input type="hidden" id="demo-selected-items" name="selected_items" value="[]">
                    <div class="so-alert so-alert-info so-mb-0">
                        <strong>Hidden input value:</strong> <code id="hidden-value-display">[]</code>
                    </div>
                </div>

                <script>
                let selectedItems = [];

                function addItem(item) {
                    if (!selectedItems.includes(item)) {
                        selectedItems.push(item);
                        updateHiddenInput();
                    }
                }

                function clearItems() {
                    selectedItems = [];
                    updateHiddenInput();
                }

                function updateHiddenInput() {
                    const hidden = document.getElementById('demo-selected-items');
                    const display = document.getElementById('hidden-value-display');
                    const value = JSON.stringify(selectedItems);
                    hidden.value = value;
                    display.textContent = value;
                }
                </script>

                <!-- Code Tabs -->
                <?= so_code_tabs('hidden-js-interactivity', [
                    [
                        'label' => 'Getting Values',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Get hidden input by name
const hidden = document.querySelector('input[name=\"user_id\"]');
const value = hidden.value;

// Get hidden input by ID
const hiddenById = document.getElementById('selected-items');
const selectedItems = JSON.parse(hiddenById.value);

// Get all hidden inputs in a form
const form = document.getElementById('my-form');
const hiddenInputs = form.querySelectorAll('input[type=\"hidden\"]');
hiddenInputs.forEach(input => {
    console.log(input.name, '=', input.value);
});

// Using UiEngine instance
const hiddenElement = UiEngine.hidden('data').setValue('test');
form.appendChild(hiddenElement.render());
console.log(hiddenElement.getValue()); // 'test'"
                    ],
                    [
                        'label' => 'Setting Values',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Set simple value
const hidden = document.querySelector('input[name=\"action\"]');
hidden.value = 'delete';

// Set JSON data
const dataHidden = document.getElementById('form-data');
dataHidden.value = JSON.stringify({
    items: [1, 2, 3],
    timestamp: Date.now(),
    user: currentUser.id
});

// Update from form interaction
document.querySelector('#item-select').addEventListener('change', (e) => {
    document.querySelector('input[name=\"selected_id\"]').value = e.target.value;
});

// Using UiEngine instance (updates DOM automatically)
const hiddenElement = UiEngine.hidden('cart_items');
hiddenElement.setValue(JSON.stringify(cartItems));

// Conditional value setting
const methodHidden = document.querySelector('input[name=\"_method\"]');
methodHidden.value = isNewRecord ? 'POST' : 'PUT';"
                    ],
                    [
                        'label' => 'Dynamic Creation',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Create hidden input with UiEngine
const hidden = UiEngine.hidden('dynamic_field')
    .setId('dynamic-field')
    .setValue('dynamic_value');

// Append to form
document.getElementById('my-form').appendChild(hidden.render());

// Create multiple hidden inputs
const hiddenFields = [
    { name: 'source', value: 'web' },
    { name: 'version', value: '2.0' },
    { name: 'timestamp', value: Date.now() }
];

const form = document.getElementById('my-form');
hiddenFields.forEach(field => {
    const input = UiEngine.hidden(field.name)
        .setValue(field.value)
        .render();
    form.appendChild(input);
});

// Remove hidden input
const toRemove = document.querySelector('input[name=\"old_field\"]');
if (toRemove) {
    toRemove.remove();
}"
                    ],
                    [
                        'label' => 'Form Submission',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Update hidden fields before submit
document.getElementById('my-form').addEventListener('submit', function(e) {
    // Update timestamp
    this.querySelector('input[name=\"submitted_at\"]').value = new Date().toISOString();

    // Serialize complex data
    const selections = getSelectedItems();
    this.querySelector('input[name=\"selections\"]').value = JSON.stringify(selections);

    // Add CSRF token if missing
    if (!this.querySelector('input[name=\"_token\"]')) {
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = getCsrfToken();
        this.appendChild(token);
    }
});

// AJAX submission with hidden fields
async function submitForm() {
    const form = document.getElementById('my-form');
    const formData = new FormData(form);

    // All hidden inputs are automatically included in FormData
    console.log('Hidden values:', {
        user_id: formData.get('user_id'),
        _token: formData.get('_token'),
        _method: formData.get('_method')
    });

    const response = await fetch(form.action, {
        method: 'POST',
        body: formData
    });
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
                <p class="so-text-muted so-mb-3">Pass configuration from PHP to JavaScript for dynamic hidden field management.</p>

                <!-- Code Tabs -->
                <?= so_code_tabs('hidden-php-js', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Create hidden input with configuration
\$hidden = UiEngine::hidden('form_config')
    ->id('form-config')
    ->value(json_encode([
        'userId' => \$user->id,
        'permissions' => \$user->permissions,
        'csrfToken' => csrf_token(),
    ]));

echo \$hidden->render();

// Export configuration for JavaScript
\$config = \$hidden->toArray();
/*
Returns:
[
    'type' => 'hidden',
    'name' => 'form_config',
    'id' => 'form-config',
    'value' => '{\"userId\":123,...}'
]
*/

// Pass multiple hidden fields as config
\$hiddenFields = [
    UiEngine::hidden('_token')->value(csrf_token())->toArray(),
    UiEngine::hidden('_method')->value('PUT')->toArray(),
    UiEngine::hidden('id')->value(\$record->id)->toArray(),
];

echo '<script>window.hiddenFieldsConfig = ' . json_encode(\$hiddenFields) . ';</script>';"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Read configuration from hidden input
const configInput = document.getElementById('form-config');
const config = JSON.parse(configInput.value);
console.log(config.userId);       // 123
console.log(config.permissions);  // ['read', 'write']
console.log(config.csrfToken);    // 'abc123...'

// Initialize hidden fields from PHP config
const hiddenFieldsConfig = window.hiddenFieldsConfig || [];
const form = document.getElementById('my-form');

hiddenFieldsConfig.forEach(config => {
    const hidden = UiEngine.hidden(config.name);
    if (config.id) hidden.setId(config.id);
    if (config.value) hidden.setValue(config.value);
    form.appendChild(hidden.render());
});

// Create hidden input from server-provided data
function initializeFromServer(serverConfig) {
    const form = document.getElementById('dynamic-form');

    // Add CSRF token
    if (serverConfig.csrfToken) {
        const csrfField = UiEngine.hidden('_token')
            .setValue(serverConfig.csrfToken)
            .render();
        form.appendChild(csrfField);
    }

    // Add record ID if editing
    if (serverConfig.recordId) {
        const idField = UiEngine.hidden('id')
            .setValue(serverConfig.recordId)
            .render();
        form.appendChild(idField);
    }
}"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Security Considerations -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Security Considerations</h3>
            </div>
            <div class="so-card-body">
                <div class="so-alert so-alert-warning so-mb-4">
                    <span class="material-icons">warning</span>
                    <div>
                        <strong>Important:</strong> Hidden inputs are NOT secure. Users can inspect and modify them using browser developer tools. Always validate hidden field values on the server.
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('hidden-security', [
                    [
                        'label' => 'PHP Server Validation',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// ALWAYS validate hidden field values on the server
public function update(Request \$request, \$id)
{
    // Validate that the user owns this record
    \$record = Record::findOrFail(\$id);

    // Don't trust hidden 'user_id' - verify ownership
    if (\$record->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

    // Validate CSRF token (framework usually handles this)
    // \$request->validate(['_token' => 'required']);

    // Validate method override is allowed
    \$allowedMethods = ['PUT', 'PATCH', 'DELETE'];
    if (\$request->has('_method') && !in_array(\$request->input('_method'), \$allowedMethods)) {
        abort(400, 'Invalid method override');
    }

    // Validate numeric IDs
    \$request->validate([
        'id' => 'required|integer|exists:records,id',
        'category_id' => 'nullable|integer|exists:categories,id',
    ]);

    // Never trust price or sensitive data from hidden fields
    // Recalculate on server
    \$total = \$this->calculateTotal(\$request->items);
}"
                    ],
                    [
                        'label' => 'Best Practices',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// DO: Use hidden fields for non-sensitive references
UiEngine.hidden('record_id').setValue(123);        // OK - will be validated
UiEngine.hidden('_token').setValue(csrfToken);     // OK - server validates
UiEngine.hidden('_method').setValue('PUT');        // OK - limited options

// DON'T: Trust hidden fields for security-critical data
// BAD: User could change this in DevTools
UiEngine.hidden('price').setValue('99.99');        // DON'T trust this!
UiEngine.hidden('is_admin').setValue('true');      // DON'T trust this!
UiEngine.hidden('discount_percent').setValue('50'); // DON'T trust this!

// BETTER: Use signed/encrypted values for sensitive data
// Server generates signed token that can't be modified
UiEngine.hidden('price_token').setValue(signedPriceToken);

// Or don't pass sensitive data at all - recalculate on server
// Just pass the item IDs, server looks up prices
UiEngine.hidden('item_ids').setValue(JSON.stringify([1, 2, 3]));"
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
                <div class="so-alert so-alert-info so-mb-3">
                    <span class="material-icons">info</span>
                    <div>Hidden inputs have no visual representation and don't require CSS classes. They are styled with <code>display: none</code> by the browser.</div>
                </div>

                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Attribute/Selector</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>input[type="hidden"]</code></td>
                                <td>CSS selector to target all hidden inputs</td>
                            </tr>
                            <tr>
                                <td><code>input[name="fieldname"]</code></td>
                                <td>Target hidden input by name attribute</td>
                            </tr>
                            <tr>
                                <td><code>#element-id</code></td>
                                <td>Target hidden input by ID (when set with <code>id()</code>)</td>
                            </tr>
                            <tr>
                                <td><code>data-*</code></td>
                                <td>Custom data attributes for JavaScript access</td>
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
                    <button class="so-tab so-active" role="tab" data-so-target="#hidden-methods">Hidden Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#hidden-inherited">Inherited Methods</button>
                    <button class="so-tab" role="tab" data-so-target="#hidden-js-methods">JavaScript API</button>
                </div>

                <!-- Tab Panes -->
                <div class="so-tab-content">
                    <!-- Hidden Methods -->
                    <div class="so-tab-pane so-fade so-show so-active" id="hidden-methods">
                        <p class="so-text-muted so-mb-2">PHP: <code>Core\UiEngine\Elements\Form\Hidden</code> extends <code>FormElement</code></p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:25%">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine::hidden()</code></td>
                                        <td><code>string $name</code></td>
                                        <td>Create a new hidden input element</td>
                                    </tr>
                                    <tr>
                                        <td><code>name()</code></td>
                                        <td><code>string $name</code></td>
                                        <td>Set the input name attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>value()</code></td>
                                        <td><code>mixed $value</code></td>
                                        <td>Set the hidden input value</td>
                                    </tr>
                                    <tr>
                                        <td><code>id()</code></td>
                                        <td><code>string $id</code></td>
                                        <td>Set the element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>data()</code></td>
                                        <td><code>string $key, mixed $value</code></td>
                                        <td>Set a data-* attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr()</code></td>
                                        <td><code>string $name, mixed $value</code></td>
                                        <td>Set a custom HTML attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>-</td>
                                        <td>Render the hidden input HTML</td>
                                    </tr>
                                    <tr>
                                        <td><code>renderGroup()</code></td>
                                        <td>-</td>
                                        <td>Same as render() (hidden inputs have no wrapper)</td>
                                    </tr>
                                    <tr>
                                        <td><code>toArray()</code></td>
                                        <td>-</td>
                                        <td>Export configuration as array</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Inherited Methods -->
                    <div class="so-tab-pane so-fade" id="hidden-inherited">
                        <p class="so-text-muted so-mb-2">Inherited from <code>FormElement</code> and <code>Element</code> base classes:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:25%">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>getName()</code></td>
                                        <td>-</td>
                                        <td>Get the field name</td>
                                    </tr>
                                    <tr>
                                        <td><code>getValue()</code></td>
                                        <td>-</td>
                                        <td>Get the field value</td>
                                    </tr>
                                    <tr>
                                        <td><code>getId()</code></td>
                                        <td>-</td>
                                        <td>Get the element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>addClass()</code></td>
                                        <td><code>string $class</code></td>
                                        <td>Add a CSS class (rarely needed for hidden)</td>
                                    </tr>
                                    <tr>
                                        <td><code>removeClass()</code></td>
                                        <td><code>string $class</code></td>
                                        <td>Remove a CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>setDataAttributes()</code></td>
                                        <td><code>array $data</code></td>
                                        <td>Set multiple data attributes at once</td>
                                    </tr>
                                    <tr>
                                        <td><code>setAttributes()</code></td>
                                        <td><code>array $attrs</code></td>
                                        <td>Set multiple HTML attributes at once</td>
                                    </tr>
                                    <tr>
                                        <td><code>when()</code></td>
                                        <td><code>bool $condition, callable $callback</code></td>
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
                                        <td>Get element type ('hidden')</td>
                                    </tr>
                                    <tr>
                                        <td><code>getConfig()</code></td>
                                        <td>-</td>
                                        <td>Get original configuration array</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- JavaScript API -->
                    <div class="so-tab-pane so-fade" id="hidden-js-methods">
                        <p class="so-text-muted so-mb-2">JavaScript: <code>Hidden</code> class extends <code>FormElement</code></p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:35%">Method</th>
                                        <th style="width:25%">Parameters</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine.hidden()</code></td>
                                        <td><code>name: string</code></td>
                                        <td>Create a new hidden input element</td>
                                    </tr>
                                    <tr>
                                        <td><code>setName()</code></td>
                                        <td><code>name: string</code></td>
                                        <td>Set the input name attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>getName()</code></td>
                                        <td>-</td>
                                        <td>Get the input name</td>
                                    </tr>
                                    <tr>
                                        <td><code>setValue()</code></td>
                                        <td><code>value: any</code></td>
                                        <td>Set the hidden input value (updates DOM if rendered)</td>
                                    </tr>
                                    <tr>
                                        <td><code>getValue()</code></td>
                                        <td>-</td>
                                        <td>Get the current value (from DOM if rendered)</td>
                                    </tr>
                                    <tr>
                                        <td><code>setId()</code></td>
                                        <td><code>id: string</code></td>
                                        <td>Set the element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>getId()</code></td>
                                        <td>-</td>
                                        <td>Get the element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>setAttr()</code></td>
                                        <td><code>name: string, value: any</code></td>
                                        <td>Set a custom HTML attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>setData()</code></td>
                                        <td><code>key: string, value: any</code></td>
                                        <td>Set a data-* attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>-</td>
                                        <td>Render to DOM element (HTMLInputElement)</td>
                                    </tr>
                                    <tr>
                                        <td><code>renderGroup()</code></td>
                                        <td>-</td>
                                        <td>Same as render() for hidden inputs</td>
                                    </tr>
                                    <tr>
                                        <td><code>toHtml()</code></td>
                                        <td>-</td>
                                        <td>Get HTML string representation</td>
                                    </tr>
                                    <tr>
                                        <td><code>toConfig()</code></td>
                                        <td>-</td>
                                        <td>Export configuration object</td>
                                    </tr>
                                    <tr>
                                        <td><code>getElement()</code></td>
                                        <td>-</td>
                                        <td>Get the rendered DOM element</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Notes</h6>
                        <ul class="so-text-muted">
                            <li>Hidden inputs don't support labels, placeholders, or help text</li>
                            <li>Validation is typically not applied to hidden inputs (validate on server)</li>
                            <li>No visual events - hidden inputs are purely data containers</li>
                            <li>Use <code>setValue()</code> to update values dynamically after render</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usage Notes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Usage Notes</h3>
            </div>
            <div class="so-card-body">
                <div class="so-row">
                    <div class="so-col-md-6">
                        <h6 class="so-text-success"><span class="material-icons so-align-middle">check_circle</span> Do</h6>
                        <ul class="so-text-muted">
                            <li>Use for CSRF tokens</li>
                            <li>Use for record IDs in edit forms</li>
                            <li>Use for HTTP method spoofing (PUT, PATCH, DELETE)</li>
                            <li>Use for tracking/referral parameters</li>
                            <li>Use for storing JSON data for form submission</li>
                            <li>Always validate hidden field values on the server</li>
                            <li>Use IDs for JavaScript access when needed</li>
                        </ul>
                    </div>
                    <div class="so-col-md-6">
                        <h6 class="so-text-danger"><span class="material-icons so-align-middle">cancel</span> Don't</h6>
                        <ul class="so-text-muted">
                            <li>Don't trust hidden fields for security</li>
                            <li>Don't store sensitive data (passwords, API keys)</li>
                            <li>Don't rely on hidden price/discount values</li>
                            <li>Don't use for user permission checks</li>
                            <li>Don't assume users can't modify values</li>
                            <li>Don't skip server-side validation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
