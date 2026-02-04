<?php
$pageTitle = 'Autocomplete';
$pageDescription = 'Autocomplete/Token Input with comprehensive features including single/multiple selection, async data, free solo mode, and more.';

require_once '../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <h1 class="so-page-title">Autocomplete</h1>
        <p class="so-page-description"><?= $pageDescription ?></p>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

        <!-- ==================================== -->
        <!-- 1. BASIC AUTOCOMPLETE -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Autocomplete</h3>
                <p class="so-card-subtitle">Single selection autocomplete with static options</p>
            </div>
            <div class="so-card-body">
                <div class="so-row">
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Select a Country</label>
                        <div class="so-autocomplete" id="basic-autocomplete"></div>
                    </div>
                </div>

                <?= so_code_tabs('basic-autocomplete-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<div class="so-autocomplete" id="basic-autocomplete" data-so-autocomplete></div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'code' => 'const autocomplete = new SOAutocomplete(\'#basic-autocomplete\', {
  placeholder: \'Type to search...\',
  options: [
    { value: \'us\', text: \'United States\' },
    { value: \'uk\', text: \'United Kingdom\' },
    { value: \'ca\', text: \'Canada\' },
    { value: \'au\', text: \'Australia\' },
    { value: \'de\', text: \'Germany\' },
    { value: \'fr\', text: \'France\' },
    { value: \'jp\', text: \'Japan\' },
    { value: \'in\', text: \'India\' }
  ]
});'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- 2. MULTIPLE SELECTION -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Multiple Selection</h3>
                <p class="so-card-subtitle">Select multiple items with token/chip display</p>
            </div>
            <div class="so-card-body">
                <div class="so-row so-g-3">
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Chips Display (Default)</label>
                        <div class="so-autocomplete" id="multiple-chips"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Chips Overflow (Single Line)</label>
                        <div class="so-autocomplete" id="multiple-overflow"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Text Display</label>
                        <div class="so-autocomplete" id="multiple-text"></div>
                    </div>
                </div>
                <?= so_code_tabs('multiple-selection-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<!-- Chips Display (wrapping) -->
<div class="so-autocomplete" id="multiple-chips"
     data-so-autocomplete
     data-so-multiple="true"></div>

<!-- Chips Overflow (single line with +N more) -->
<div class="so-autocomplete" id="multiple-overflow"
     data-so-autocomplete
     data-so-multiple="true"
     data-so-display-mode="chips-overflow"></div>

<!-- Text Display ("3 selected") -->
<div class="so-autocomplete" id="multiple-text"
     data-so-autocomplete
     data-so-multiple="true"
     data-so-display-mode="text"></div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'code' => '// Initialize with skills options
const skillsOptions = [
  { value: \'js\', text: \'JavaScript\' },
  { value: \'py\', text: \'Python\' },
  { value: \'java\', text: \'Java\' },
  { value: \'php\', text: \'PHP\' },
  { value: \'ruby\', text: \'Ruby\' },
  { value: \'go\', text: \'Go\' },
  { value: \'rust\', text: \'Rust\' },
  { value: \'ts\', text: \'TypeScript\' }
];

new SOAutocomplete(\'#multiple-chips\', { options: skillsOptions });
new SOAutocomplete(\'#multiple-overflow\', { options: skillsOptions, maxVisibleTokens: 2 });
new SOAutocomplete(\'#multiple-text\', { options: skillsOptions });'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- 3. FREE SOLO MODE -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Free Solo Mode</h3>
                <p class="so-card-subtitle">Allow custom values not in predefined list</p>
            </div>
            <div class="so-card-body">
                <div class="so-row so-g-3">
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Email Tags (Comma/Semicolon Delimited)</label>
                        <div class="so-autocomplete" id="free-solo-tags" data-so-multiple="true" data-so-free-solo="true"></div>
                        <small class="so-form-text">Type email and press comma, semicolon, or Enter to add</small>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">With Validation</label>
                        <div class="so-autocomplete" id="free-solo-validation" data-so-multiple="true" data-so-free-solo="true"></div>
                        <small class="so-form-text">Only allows valid email addresses</small>
                    </div>
                </div>
                <?= so_code_tabs('free-solo-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<div class="so-autocomplete" id="free-solo-tags"
     data-so-autocomplete
     data-so-multiple="true"
     data-so-free-solo="true"></div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'code' => '// Basic free solo with delimiters
new SOAutocomplete(\'#free-solo-tags\', {
  placeholder: \'Add emails...\',
  tokenDelimiters: [\',\', \';\'],
  options: [
    { value: \'john@example.com\', text: \'john@example.com\' },
    { value: \'jane@example.com\', text: \'jane@example.com\' }
  ]
});

// Free solo with email validation
new SOAutocomplete(\'#free-solo-validation\', {
  placeholder: \'Add valid emails...\',
  tokenDelimiters: [\',\', \';\'],
  tokenValidation: (value) => {
    const emailRegex = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
    return emailRegex.test(value);
  },
  options: []
});'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- 4. ASYNC DATA LOADING -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Async Data Loading</h3>
                <p class="so-card-subtitle">Load options from remote API with search-as-you-type</p>
            </div>
            <div class="so-card-body">
                <div class="so-row so-g-3">
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">User Search (Simulated API)</label>
                        <div class="so-autocomplete" id="async-users"></div>
                        <small class="so-form-text">Type to search users from API</small>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Load on Open</label>
                        <div class="so-autocomplete" id="async-load-open"></div>
                        <small class="so-form-text">Data loads when dropdown opens</small>
                    </div>
                </div>
                <?= so_code_tabs('async-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<div class="so-autocomplete" id="async-users"></div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'code' => '// Async search-as-you-type
new SOAutocomplete(\'#async-users\', {
  async: true,
  asyncUrl: \'/api/users/search\',
  asyncMethod: \'GET\',
  asyncParam: \'q\',
  minSearchLength: 2,
  debounceTime: 300,
  loadingText: \'Searching users...\'
});

// Load on open
new SOAutocomplete(\'#async-load-open\', {
  async: true,
  asyncUrl: \'/api/categories\',
  loadOnOpen: true
});'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- 5. GROUPED OPTIONS -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Grouped Options</h3>
                <p class="so-card-subtitle">Organize options into categories with group headers</p>
            </div>
            <div class="so-card-body">
                <div class="so-row">
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Select Technology</label>
                        <div class="so-autocomplete" id="grouped-tech"></div>
                    </div>
                </div>
                <?= so_code_tabs('grouped-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<div class="so-autocomplete" id="grouped-tech"></div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'code' => 'new SOAutocomplete(\'#grouped-tech\', {
  grouped: true,
  groupBy: (option) => option.category,
  options: [
    { value: \'js\', text: \'JavaScript\', category: \'Frontend\' },
    { value: \'ts\', text: \'TypeScript\', category: \'Frontend\' },
    { value: \'react\', text: \'React\', category: \'Frontend\' },
    { value: \'vue\', text: \'Vue\', category: \'Frontend\' },
    { value: \'node\', text: \'Node.js\', category: \'Backend\' },
    { value: \'python\', text: \'Python\', category: \'Backend\' },
    { value: \'php\', text: \'PHP\', category: \'Backend\' },
    { value: \'mysql\', text: \'MySQL\', category: \'Database\' },
    { value: \'mongodb\', text: \'MongoDB\', category: \'Database\' }
  ]
});'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- 6. CUSTOM TEMPLATES -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Custom Templates</h3>
                <p class="so-card-subtitle">Customize option and token appearance</p>
            </div>
            <div class="so-card-body">
                <div class="so-row so-g-3">
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Options with Icons</label>
                        <div class="so-autocomplete" id="template-icons"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Options with Avatars</label>
                        <div class="so-autocomplete" id="template-avatars"></div>
                    </div>
                </div>
                <?= so_code_tabs('custom-template-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<div class="so-autocomplete" id="template-icons"></div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'code' => 'new SOAutocomplete(\'#template-icons\', {
  optionTemplate: (option) => {
    return `
      <div style="display: flex; align-items: center; gap: 0.75rem;">
        <span class="material-icons" style="color: var(--so-primary);">${option.icon}</span>
        <span>${option.text}</span>
      </div>
    `;
  },
  options: [
    { value: \'home\', text: \'Home\', icon: \'home\' },
    { value: \'settings\', text: \'Settings\', icon: \'settings\' },
    { value: \'profile\', text: \'Profile\', icon: \'person\' },
    { value: \'notifications\', text: \'Notifications\', icon: \'notifications\' }
  ]
});'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- 7. SIZE VARIANTS -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
                <p class="so-card-subtitle">Small, medium, and large sizes</p>
            </div>
            <div class="so-card-body">
                <div class="so-row so-g-3">
                    <div class="so-col-12 so-col-md-4">
                        <label class="so-form-label">Small</label>
                        <div class="so-autocomplete so-autocomplete-sm" id="size-sm"></div>
                    </div>
                    <div class="so-col-12 so-col-md-4">
                        <label class="so-form-label">Medium (Default)</label>
                        <div class="so-autocomplete" id="size-md"></div>
                    </div>
                    <div class="so-col-12 so-col-md-4">
                        <label class="so-form-label">Large</label>
                        <div class="so-autocomplete so-autocomplete-lg" id="size-lg"></div>
                    </div>
                </div>
                <?= so_code_tabs('size-variants-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<!-- Small -->
<div class="so-autocomplete so-autocomplete-sm" data-so-autocomplete></div>

<!-- Medium (Default) -->
<div class="so-autocomplete" data-so-autocomplete></div>

<!-- Large -->
<div class="so-autocomplete so-autocomplete-lg" data-so-autocomplete></div>'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- 8. COLOR VARIANTS -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Color Variants</h3>
                <p class="so-card-subtitle">Theme color variants for focus states and tokens - tokens automatically match the variant color</p>
            </div>
            <div class="so-card-body">
                <div class="so-row so-g-3">
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Primary</label>
                        <div class="so-autocomplete so-autocomplete-primary" id="variant-primary"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Secondary</label>
                        <div class="so-autocomplete so-autocomplete-secondary" id="variant-secondary"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Success</label>
                        <div class="so-autocomplete so-autocomplete-success" id="variant-success"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Danger</label>
                        <div class="so-autocomplete so-autocomplete-danger" id="variant-danger"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Warning</label>
                        <div class="so-autocomplete so-autocomplete-warning" id="variant-warning"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Info</label>
                        <div class="so-autocomplete so-autocomplete-info" id="variant-info"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Dark</label>
                        <div class="so-autocomplete so-autocomplete-dark" id="variant-dark"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Light</label>
                        <div class="so-autocomplete so-autocomplete-light" id="variant-light"></div>
                    </div>
                </div>
                <?= so_code_tabs('color-variants-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<!-- Color variants - tokens automatically match the variant color -->
<div class="so-autocomplete so-autocomplete-primary" data-so-multiple="true"></div>
<div class="so-autocomplete so-autocomplete-secondary" data-so-multiple="true"></div>
<div class="so-autocomplete so-autocomplete-success" data-so-multiple="true"></div>
<div class="so-autocomplete so-autocomplete-danger" data-so-multiple="true"></div>
<div class="so-autocomplete so-autocomplete-warning" data-so-multiple="true"></div>
<div class="so-autocomplete so-autocomplete-info" data-so-multiple="true"></div>
<div class="so-autocomplete so-autocomplete-dark" data-so-multiple="true"></div>
<div class="so-autocomplete so-autocomplete-light" data-so-multiple="true"></div>'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- 9. ADVANCED FEATURES -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Advanced Features</h3>
                <p class="so-card-subtitle">Match highlighting, min/max selections, disabled options, and more</p>
            </div>
            <div class="so-card-body">
                <div class="so-row so-g-3">
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">With Match Highlighting</label>
                        <div class="so-autocomplete" id="feature-highlight" data-so-highlight-matches="true"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Max 3 Selections</label>
                        <div class="so-autocomplete" id="feature-max" data-so-multiple="true" data-so-max-selections="3"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">With Disabled Options</label>
                        <div class="so-autocomplete" id="feature-disabled"></div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Open on Focus</label>
                        <div class="so-autocomplete" id="feature-open-focus" data-so-open-on-focus="true"></div>
                    </div>
                </div>
                <?= so_code_tabs('advanced-features-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<!-- Highlight matches -->
<div class="so-autocomplete" data-so-highlight-matches="true"></div>

<!-- Max selections -->
<div class="so-autocomplete" data-so-multiple="true" data-so-max-selections="3"></div>

<!-- Disabled options -->
<div class="so-autocomplete" id="feature-disabled"></div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'code' => 'new SOAutocomplete(\'#feature-disabled\', {
  options: [
    { value: \'1\', text: \'Option 1\' },
    { value: \'2\', text: \'Option 2\', disabled: true },
    { value: \'3\', text: \'Option 3\' }
  ]
});'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- 10. FORM INTEGRATION -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Form Integration</h3>
                <p class="so-card-subtitle">Labels, validation, required fields, and error states</p>
            </div>
            <div class="so-card-body">
                <form class="so-row so-g-3">
                    <div class="so-col-12 so-col-md-6">
                        <label for="form-country" class="so-form-label">Country <span class="so-text-danger">*</span></label>
                        <div class="so-autocomplete" id="form-country"></div>
                        <small class="so-form-text">Select your country</small>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label for="form-skills" class="so-form-label">Skills</label>
                        <div class="so-autocomplete so-autocomplete-success" id="form-skills" data-so-multiple="true"></div>
                        <div class="so-valid-feedback" style="display: flex;">
                            <span class="material-icons" style="margin-right: 0.5rem;">check_circle</span>
                            Looks good!
                        </div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label for="form-error" class="so-form-label">With Error</label>
                        <div class="so-autocomplete so-autocomplete-error" id="form-error"></div>
                        <div class="so-invalid-feedback" style="display: flex;">
                            <span class="material-icons" style="margin-right: 0.5rem;">error</span>
                            Please select an option
                        </div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label for="form-warning" class="so-form-label">With Warning</label>
                        <div class="so-autocomplete so-autocomplete-warning" id="form-warning"></div>
                        <div class="so-warning-feedback" style="display: flex; color: var(--so-warning); margin-top: 0.25rem; font-size: 0.875rem;">
                            <span class="material-icons" style="margin-right: 0.5rem; font-size: 1rem;">warning</span>
                            Limited options available
                        </div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label for="form-info" class="so-form-label">With Info</label>
                        <div class="so-autocomplete so-autocomplete-info" id="form-info"></div>
                        <div class="so-info-feedback" style="display: flex; color: var(--so-info); margin-top: 0.25rem; font-size: 0.875rem;">
                            <span class="material-icons" style="margin-right: 0.5rem; font-size: 1rem;">info</span>
                            Select your preferred options
                        </div>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label for="form-disabled" class="so-form-label">Disabled</label>
                        <div class="so-autocomplete so-autocomplete-disabled" id="form-disabled"></div>
                    </div>
                </form>
                <?= so_code_tabs('form-integration-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<form>
  <!-- Required field with helper text -->
  <label class="so-form-label">Country <span class="so-text-danger">*</span></label>
  <div class="so-autocomplete" data-so-autocomplete></div>
  <small class="so-form-text">Select your country</small>

  <!-- Success validation -->
  <label class="so-form-label">Skills</label>
  <div class="so-autocomplete so-autocomplete-success" data-so-multiple="true"></div>
  <div class="so-valid-feedback" style="display: flex;">
    <span class="material-icons">check_circle</span>
    Looks good!
  </div>

  <!-- Error validation -->
  <label class="so-form-label">With Error</label>
  <div class="so-autocomplete so-autocomplete-error"></div>
  <div class="so-invalid-feedback" style="display: flex;">
    <span class="material-icons">error</span>
    Please select an option
  </div>

  <!-- Warning validation -->
  <label class="so-form-label">With Warning</label>
  <div class="so-autocomplete so-autocomplete-warning"></div>
  <div class="so-warning-feedback" style="display: flex; color: var(--so-warning);">
    <span class="material-icons">warning</span>
    Limited options available
  </div>

  <!-- Info validation -->
  <label class="so-form-label">With Info</label>
  <div class="so-autocomplete so-autocomplete-info"></div>
  <div class="so-info-feedback" style="display: flex; color: var(--so-info);">
    <span class="material-icons">info</span>
    Select your preferred options
  </div>

  <!-- Disabled state -->
  <label class="so-form-label">Disabled</label>
  <div class="so-autocomplete so-autocomplete-disabled"></div>
</form>'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- 11. REAL-WORLD EXAMPLES -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Real-World Examples</h3>
                <p class="so-card-subtitle">Practical use cases</p>
            </div>
            <div class="so-card-body">
                <div class="so-row so-g-4">
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">User/Contact Search</label>
                        <div class="so-autocomplete" id="example-users"></div>
                        <small class="so-form-text">Search users by name or email</small>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Tag Management</label>
                        <div class="so-autocomplete" id="example-tags" data-so-multiple="true" data-so-free-solo="true"></div>
                        <small class="so-form-text">Add custom tags or select from existing</small>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Email Recipients</label>
                        <div class="so-autocomplete" id="example-emails" data-so-multiple="true" data-so-free-solo="true"></div>
                        <small class="so-form-text">Type email addresses separated by comma</small>
                    </div>
                    <div class="so-col-12 so-col-md-6">
                        <label class="so-form-label">Country Selector</label>
                        <div class="so-autocomplete so-autocomplete-sm" id="example-countries"></div>
                        <small class="so-form-text">Fast country selection with search</small>
                    </div>
                </div>
                <?= so_code_tabs('real-world-code', [
                    [
                        'label' => 'HTML',
                        'language' => 'html',
                        'code' => '<!-- User search with async -->
<div class="so-autocomplete" id="example-users"></div>

<!-- Tag management -->
<div class="so-autocomplete" id="example-tags"
     data-so-multiple="true"
     data-so-free-solo="true"></div>

<!-- Email recipients with validation -->
<div class="so-autocomplete" id="example-emails"
     data-so-multiple="true"
     data-so-free-solo="true"></div>'
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'code' => '// User search with async
new SOAutocomplete(\'#example-users\', {
  async: true,
  asyncUrl: \'/api/users/search\',
  minSearchLength: 2,
  optionTemplate: (option) => `
    <div style="display: flex; align-items: center; gap: 0.5rem;">
      <img src="${option.avatar}" style="width: 32px; height: 32px; border-radius: 50%;">
      <div>
        <div style="font-weight: 500;">${option.text}</div>
        <div style="font-size: 0.875rem; color: var(--so-text-muted);">${option.email}</div>
      </div>
    </div>
  `
});

// Email recipients with validation
new SOAutocomplete(\'#example-emails\', {
  tokenDelimiters: [\',\', \';\'],
  tokenValidation: (value) => /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/.test(value)
});'
                    ]
                ]) ?>
            </div>
        </div>

        <!-- ==================================== -->
        <!-- API REFERENCE -->
        <!-- ==================================== -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <h5 class="so-mt-0">Methods</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Method</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>open()</code></td>
                                <td>Open the dropdown</td>
                            </tr>
                            <tr>
                                <td><code>close()</code></td>
                                <td>Close the dropdown</td>
                            </tr>
                            <tr>
                                <td><code>toggle()</code></td>
                                <td>Toggle dropdown state</td>
                            </tr>
                            <tr>
                                <td><code>getValue()</code></td>
                                <td>Get single selected value</td>
                            </tr>
                            <tr>
                                <td><code>getValues()</code></td>
                                <td>Get array of selected values</td>
                            </tr>
                            <tr>
                                <td><code>setValue(value)</code></td>
                                <td>Set single value</td>
                            </tr>
                            <tr>
                                <td><code>setValues(values)</code></td>
                                <td>Set multiple values</td>
                            </tr>
                            <tr>
                                <td><code>addToken(value, text)</code></td>
                                <td>Add a token (multiple mode)</td>
                            </tr>
                            <tr>
                                <td><code>removeToken(index)</code></td>
                                <td>Remove token by index</td>
                            </tr>
                            <tr>
                                <td><code>clear()</code></td>
                                <td>Clear all selections</td>
                            </tr>
                            <tr>
                                <td><code>setOptions(options)</code></td>
                                <td>Set all options</td>
                            </tr>
                            <tr>
                                <td><code>loadOptions(query)</code></td>
                                <td>Load options from remote URL</td>
                            </tr>
                            <tr>
                                <td><code>enable()</code></td>
                                <td>Enable component</td>
                            </tr>
                            <tr>
                                <td><code>disable()</code></td>
                                <td>Disable component</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4">Events</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>so:autocomplete:open</code></td>
                                <td>Before dropdown opens (cancelable)</td>
                            </tr>
                            <tr>
                                <td><code>so:autocomplete:opened</code></td>
                                <td>After dropdown opened</td>
                            </tr>
                            <tr>
                                <td><code>so:autocomplete:select</code></td>
                                <td>Item selected</td>
                            </tr>
                            <tr>
                                <td><code>so:autocomplete:change</code></td>
                                <td>Selection changed</td>
                            </tr>
                            <tr>
                                <td><code>so:autocomplete:token-add</code></td>
                                <td>Token added (multiple mode)</td>
                            </tr>
                            <tr>
                                <td><code>so:autocomplete:token-remove</code></td>
                                <td>Token removed</td>
                            </tr>
                            <tr>
                                <td><code>so:autocomplete:search</code></td>
                                <td>Search query changed</td>
                            </tr>
                            <tr>
                                <td><code>so:autocomplete:load-end</code></td>
                                <td>Async data loaded</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    // Sample data for demos
    const countries = [{
            value: 'us',
            text: 'United States'
        },
        {
            value: 'uk',
            text: 'United Kingdom'
        },
        {
            value: 'ca',
            text: 'Canada'
        },
        {
            value: 'au',
            text: 'Australia'
        },
        {
            value: 'de',
            text: 'Germany'
        },
        {
            value: 'fr',
            text: 'France'
        },
        {
            value: 'jp',
            text: 'Japan'
        },
        {
            value: 'in',
            text: 'India'
        },
        {
            value: 'br',
            text: 'Brazil'
        },
        {
            value: 'mx',
            text: 'Mexico'
        }
    ];

    const skills = [{
            value: 'js',
            text: 'JavaScript'
        },
        {
            value: 'py',
            text: 'Python'
        },
        {
            value: 'java',
            text: 'Java'
        },
        {
            value: 'php',
            text: 'PHP'
        },
        {
            value: 'ruby',
            text: 'Ruby'
        },
        {
            value: 'go',
            text: 'Go'
        },
        {
            value: 'rust',
            text: 'Rust'
        },
        {
            value: 'ts',
            text: 'TypeScript'
        },
        {
            value: 'cpp',
            text: 'C++'
        },
        {
            value: 'csharp',
            text: 'C#'
        }
    ];

    // Initialize all demos
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Basic Autocomplete
        if (document.getElementById('basic-autocomplete')) {
            try {
                new SOAutocomplete('#basic-autocomplete', {
                    placeholder: 'Type to search countries...',
                    options: countries,
                    highlightMatches: true
                });
                console.log('✓ Basic autocomplete initialized');
            } catch (error) {
                console.error('✗ Error initializing basic autocomplete:', error);
            }
        }

        // 2. Multiple Selection
        if (document.getElementById('multiple-chips')) {
            try {
                new SOAutocomplete('#multiple-chips', {
                    placeholder: 'Select skills...',
                    multiple: true,
                    options: skills
                });
                console.log('✓ Multiple chips initialized');
            } catch (error) {
                console.error('✗ Error initializing multiple chips:', error);
            }
        }

        if (document.getElementById('multiple-overflow')) {
            new SOAutocomplete('#multiple-overflow', {
                placeholder: 'Select skills...',
                multiple: true,
                displayMode: 'chips-overflow',
                options: skills,
                maxVisibleTokens: 2
            });
        }

        if (document.getElementById('multiple-text')) {
            new SOAutocomplete('#multiple-text', {
                placeholder: 'Select skills...',
                multiple: true,
                displayMode: 'text',
                options: skills
            });
        }

        // 3. Free Solo Mode
        if (document.getElementById('free-solo-tags')) {
            new SOAutocomplete('#free-solo-tags', {
                placeholder: 'Add emails...',
                multiple: true,
                freeSolo: true,
                tokenDelimiters: [',', ';'],
                options: [{
                        value: 'john@example.com',
                        text: 'john@example.com'
                    },
                    {
                        value: 'jane@example.com',
                        text: 'jane@example.com'
                    }
                ]
            });
        }

        if (document.getElementById('free-solo-validation')) {
            new SOAutocomplete('#free-solo-validation', {
                placeholder: 'Add valid emails...',
                multiple: true,
                freeSolo: true,
                tokenDelimiters: [',', ';'],
                tokenValidation: (value) => {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(value);
                },
                options: []
            });
        }

        // 4. Async - Note: These would connect to real APIs in production
        // For demo purposes, using static data
        if (document.getElementById('async-users')) {
            new SOAutocomplete('#async-users', {
                placeholder: 'Search users...',
                options: [{
                        value: '1',
                        text: 'John Doe'
                    },
                    {
                        value: '2',
                        text: 'Jane Smith'
                    },
                    {
                        value: '3',
                        text: 'Bob Johnson'
                    }
                ]
            });
        }

        if (document.getElementById('async-load-open')) {
            new SOAutocomplete('#async-load-open', {
                placeholder: 'Click to load...',
                options: countries
            });
        }

        // 5. Grouped Options
        if (document.getElementById('grouped-tech')) {
            new SOAutocomplete('#grouped-tech', {
                placeholder: 'Select technology...',
                grouped: true,
                groupBy: (option) => option.category,
                options: [{
                        value: 'js',
                        text: 'JavaScript',
                        category: 'Frontend'
                    },
                    {
                        value: 'ts',
                        text: 'TypeScript',
                        category: 'Frontend'
                    },
                    {
                        value: 'react',
                        text: 'React',
                        category: 'Frontend'
                    },
                    {
                        value: 'vue',
                        text: 'Vue',
                        category: 'Frontend'
                    },
                    {
                        value: 'node',
                        text: 'Node.js',
                        category: 'Backend'
                    },
                    {
                        value: 'python',
                        text: 'Python',
                        category: 'Backend'
                    },
                    {
                        value: 'php',
                        text: 'PHP',
                        category: 'Backend'
                    },
                    {
                        value: 'mysql',
                        text: 'MySQL',
                        category: 'Database'
                    },
                    {
                        value: 'mongodb',
                        text: 'MongoDB',
                        category: 'Database'
                    }
                ]
            });
        }

        // 6. Custom Templates
        if (document.getElementById('template-icons')) {
            new SOAutocomplete('#template-icons', {
                placeholder: 'Select an option...',
                optionTemplate: (option) => {
                    return `
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span class="material-icons" style="color: var(--so-primary);">${option.icon}</span>
                        <span>${option.text}</span>
                    </div>
                `;
                },
                options: [{
                        value: 'home',
                        text: 'Home',
                        icon: 'home'
                    },
                    {
                        value: 'settings',
                        text: 'Settings',
                        icon: 'settings'
                    },
                    {
                        value: 'profile',
                        text: 'Profile',
                        icon: 'person'
                    },
                    {
                        value: 'notifications',
                        text: 'Notifications',
                        icon: 'notifications'
                    },
                    {
                        value: 'messages',
                        text: 'Messages',
                        icon: 'mail'
                    }
                ]
            });
        }

        if (document.getElementById('template-avatars')) {
            new SOAutocomplete('#template-avatars', {
                placeholder: 'Select user...',
                optionTemplate: (option) => {
                    return `
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <img src="${option.avatar}"
                             alt="${option.text}"
                             style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                        <div>
                            <div style="font-weight: 500;">${option.text}</div>
                            ${option.email ? `<div style="font-size: 0.875rem; color: var(--so-text-muted);">${option.email}</div>` : ''}
                        </div>
                    </div>
                `;
                },
                options: [{
                        value: '1',
                        text: 'John Doe',
                        email: 'john.doe@example.com',
                        avatar: 'https://i.pravatar.cc/150?img=12'
                    },
                    {
                        value: '2',
                        text: 'Jane Smith',
                        email: 'jane.smith@example.com',
                        avatar: 'https://i.pravatar.cc/150?img=5'
                    },
                    {
                        value: '3',
                        text: 'Bob Johnson',
                        email: 'bob.johnson@example.com',
                        avatar: 'https://i.pravatar.cc/150?img=33'
                    },
                    {
                        value: '4',
                        text: 'Alice Williams',
                        email: 'alice.w@example.com',
                        avatar: 'https://i.pravatar.cc/150?img=9'
                    },
                    {
                        value: '5',
                        text: 'Charlie Brown',
                        email: 'charlie.b@example.com',
                        avatar: 'https://i.pravatar.cc/150?img=68'
                    }
                ]
            });
        }

        // 7. Size Variants
        ['size-sm', 'size-md', 'size-lg'].forEach(id => {
            if (document.getElementById(id)) {
                new SOAutocomplete(`#${id}`, {
                    placeholder: 'Select option...',
                    options: countries
                });
            }
        });

        // 8. Color Variants - tokens automatically match the variant color
        ['variant-primary', 'variant-secondary', 'variant-success', 'variant-danger', 'variant-warning', 'variant-info', 'variant-dark', 'variant-light'].forEach(id => {
            if (document.getElementById(id)) {
                new SOAutocomplete(`#${id}`, {
                    placeholder: 'Select skills...',
                    multiple: true,
                    options: skills,
                    value: ['js', 'py'] // Pre-select to show colored tokens
                });
            }
        });

        // 9. Advanced Features
        if (document.getElementById('feature-highlight')) {
            new SOAutocomplete('#feature-highlight', {
                placeholder: 'Type to see highlighting...',
                highlightMatches: true,
                options: countries
            });
        }

        if (document.getElementById('feature-max')) {
            new SOAutocomplete('#feature-max', {
                placeholder: 'Max 3 selections...',
                multiple: true,
                maxSelections: 3,
                options: skills
            });
        }

        if (document.getElementById('feature-disabled')) {
            new SOAutocomplete('#feature-disabled', {
                placeholder: 'Some options disabled...',
                options: [{
                        value: '1',
                        text: 'Option 1'
                    },
                    {
                        value: '2',
                        text: 'Option 2 (Disabled)',
                        disabled: true
                    },
                    {
                        value: '3',
                        text: 'Option 3'
                    },
                    {
                        value: '4',
                        text: 'Option 4 (Disabled)',
                        disabled: true
                    },
                    {
                        value: '5',
                        text: 'Option 5'
                    }
                ]
            });
        }

        if (document.getElementById('feature-open-focus')) {
            new SOAutocomplete('#feature-open-focus', {
                placeholder: 'Focus to open...',
                openOnFocus: true,
                options: skills
            });
        }

        // 10. Form Integration
        if (document.getElementById('form-country')) {
            new SOAutocomplete('#form-country', {
                placeholder: 'Select country...',
                options: countries
            });
        }

        if (document.getElementById('form-skills')) {
            new SOAutocomplete('#form-skills', {
                placeholder: 'Select skills...',
                multiple: true,
                options: skills
            });
        }

        if (document.getElementById('form-error')) {
            new SOAutocomplete('#form-error', {
                placeholder: 'This has an error...',
                options: countries
            });
        }

        if (document.getElementById('form-warning')) {
            new SOAutocomplete('#form-warning', {
                placeholder: 'Select option...',
                options: skills.slice(0, 3) // Limited options
            });
        }

        if (document.getElementById('form-info')) {
            new SOAutocomplete('#form-info', {
                placeholder: 'Choose your preferences...',
                multiple: true,
                options: skills
            });
        }

        if (document.getElementById('form-disabled')) {
            const disabled = new SOAutocomplete('#form-disabled', {
                placeholder: 'Disabled...',
                options: countries
            });
            disabled.disable();
        }

        // 11. Real-World Examples
        if (document.getElementById('example-users')) {
            new SOAutocomplete('#example-users', {
                placeholder: 'Search users...',
                options: [{
                        value: '1',
                        text: 'John Doe'
                    },
                    {
                        value: '2',
                        text: 'Jane Smith'
                    },
                    {
                        value: '3',
                        text: 'Bob Johnson'
                    },
                    {
                        value: '4',
                        text: 'Alice Williams'
                    }
                ]
            });
        }

        if (document.getElementById('example-tags')) {
            new SOAutocomplete('#example-tags', {
                placeholder: 'Add tags...',
                multiple: true,
                freeSolo: true,
                tokenDelimiters: [',', ';'],
                options: [{
                        value: 'javascript',
                        text: 'javascript'
                    },
                    {
                        value: 'python',
                        text: 'python'
                    },
                    {
                        value: 'react',
                        text: 'react'
                    },
                    {
                        value: 'vue',
                        text: 'vue'
                    }
                ]
            });
        }

        if (document.getElementById('example-emails')) {
            new SOAutocomplete('#example-emails', {
                placeholder: 'Type email addresses...',
                multiple: true,
                freeSolo: true,
                tokenDelimiters: [',', ';'],
                tokenValidation: (value) => {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(value);
                },
                options: []
            });
        }

        if (document.getElementById('example-countries')) {
            new SOAutocomplete('#example-countries', {
                placeholder: 'Select country...',
                options: countries
            });
        }
    });
</script>

</div>
</main>

<?php require_once '../includes/footer.php'; ?>