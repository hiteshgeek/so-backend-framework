<?php
/**
 * SixOrbit UI Engine - Autocomplete Element Demo
 */

$pageTitle = 'Autocomplete - UI Engine';
$pageDescription = 'Autocomplete input with single/multiple selection, async data, and token support';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Autocomplete</h1>
            <p class="so-page-subtitle">Autocomplete input element with single/multiple selection, static or remote data, and token/chip display.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Autocomplete -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Autocomplete</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label">Country</label>
                    <div class="so-autocomplete" id="demo-basic-autocomplete"></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-autocomplete', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$autocomplete = UiEngine::autocomplete('country')
    ->label('Country')
    ->placeholder('Type to search...')
    ->options([
        ['value' => 'us', 'text' => 'United States'],
        ['value' => 'uk', 'text' => 'United Kingdom'],
        ['value' => 'ca', 'text' => 'Canada'],
        ['value' => 'au', 'text' => 'Australia'],
        ['value' => 'de', 'text' => 'Germany'],
        ['value' => 'fr', 'text' => 'France'],
    ]);

echo \$autocomplete->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "import { UiEngine } from './ui-engine/UiEngine.js';

const autocomplete = UiEngine.autocomplete('country')
    .placeholder('Type to search...')
    .options([
        { value: 'us', text: 'United States' },
        { value: 'uk', text: 'United Kingdom' },
        { value: 'ca', text: 'Canada' },
        { value: 'au', text: 'Australia' },
        { value: 'de', text: 'Germany' },
        { value: 'fr', text: 'France' }
    ]);

document.getElementById('demo-container').appendChild(autocomplete.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label">Country</label>
    <div class="so-autocomplete" id="country">
        <div class="so-autocomplete-container">
            <input type="text" class="so-autocomplete-input"
                   placeholder="Type to search..." autocomplete="off"
                   role="combobox" aria-expanded="false">
            <button type="button" class="so-autocomplete-clear"
                    style="display: none;" aria-label="Clear all">
                <span class="material-icons">close</span>
            </button>
            <span class="so-autocomplete-arrow">
                <span class="material-icons">expand_more</span>
            </span>
        </div>
        <div class="so-autocomplete-dropdown" role="listbox">
            <div class="so-autocomplete-loading" style="display: none;">
                <span class="so-spinner so-spinner-sm"></span>
                <span>Loading...</span>
            </div>
            <div class="so-autocomplete-options"></div>
            <div class="so-autocomplete-no-results" style="display: none;">
                No results found
            </div>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Multiple Selection -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Multiple Selection</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label">Select Skills</label>
                    <div class="so-autocomplete" id="demo-multiple-autocomplete" data-so-multiple="true"></div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('autocomplete-multiple', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$autocomplete = UiEngine::autocomplete('skills')
    ->label('Select Skills')
    ->placeholder('Add skills...')
    ->multiple()
    ->options([
        ['value' => 'js', 'text' => 'JavaScript'],
        ['value' => 'py', 'text' => 'Python'],
        ['value' => 'php', 'text' => 'PHP'],
        ['value' => 'java', 'text' => 'Java'],
        ['value' => 'ruby', 'text' => 'Ruby'],
        ['value' => 'go', 'text' => 'Go'],
    ]);

echo \$autocomplete->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const autocomplete = UiEngine.autocomplete('skills')
    .placeholder('Add skills...')
    .multiple()
    .options([
        { value: 'js', text: 'JavaScript' },
        { value: 'py', text: 'Python' },
        { value: 'php', text: 'PHP' },
        { value: 'java', text: 'Java' },
        { value: 'ruby', text: 'Ruby' },
        { value: 'go', text: 'Go' }
    ]);

document.getElementById('demo-container').appendChild(autocomplete.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label">Select Skills</label>
    <div class="so-autocomplete so-autocomplete-multiple so-autocomplete-display-chips"
         id="skills" data-so-multiple="true">
        <div class="so-autocomplete-container">
            <div class="so-autocomplete-tokens">
                <input type="text" class="so-autocomplete-input"
                       placeholder="Add skills..." autocomplete="off"
                       role="combobox" aria-expanded="false">
            </div>
            <button type="button" class="so-autocomplete-clear"
                    style="display: none;" aria-label="Clear all">
                <span class="material-icons">close</span>
            </button>
            <span class="so-autocomplete-arrow">
                <span class="material-icons">expand_more</span>
            </span>
        </div>
        <div class="so-autocomplete-dropdown" role="listbox">
            <div class="so-autocomplete-loading" style="display: none;">
                <span class="so-spinner so-spinner-sm"></span>
                <span>Loading...</span>
            </div>
            <div class="so-autocomplete-options"></div>
            <div class="so-autocomplete-no-results" style="display: none;">
                No results found
            </div>
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Display Modes -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Display Modes</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Chips (default)</label>
                            <div class="so-autocomplete" id="demo-display-chips"></div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Chips Overflow</label>
                            <div class="so-autocomplete" id="demo-display-chips-overflow"></div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Text Display</label>
                            <div class="so-autocomplete" id="demo-display-text"></div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('autocomplete-display', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Chips display (default - wrapping)
\$autocomplete = UiEngine::autocomplete('tags')
    ->multiple()
    ->displayMode('chips');

// Chips overflow (single line with +N more)
\$autocomplete = UiEngine::autocomplete('tags')
    ->multiple()
    ->displayMode('chips-overflow')
    ->maxVisibleTokens(2);

// Text display (\"3 selected\")
\$autocomplete = UiEngine::autocomplete('tags')
    ->multiple()
    ->displayMode('text');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Chips display (default - wrapping)
UiEngine.autocomplete('tags')
    .multiple()
    .displayMode('chips');

// Chips overflow (single line with +N more)
UiEngine.autocomplete('tags')
    .multiple()
    .displayMode('chips-overflow')
    .maxVisibleTokens(2);

// Text display (\"3 selected\")
UiEngine.autocomplete('tags')
    .multiple()
    .displayMode('text');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Chips display (wrapping) -->
<div class="so-autocomplete so-autocomplete-display-chips" data-so-multiple="true">
    <!-- ... -->
</div>

<!-- Chips overflow (single line) -->
<div class="so-autocomplete so-autocomplete-display-chips-overflow" data-so-multiple="true">
    <!-- ... -->
</div>

<!-- Text display -->
<div class="so-autocomplete so-autocomplete-display-text" data-so-multiple="true">
    <!-- ... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Remote Data Source -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Remote Data Source</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group so-mb-4">
                    <label class="so-form-label">Search Products (Simulated Async)</label>
                    <div class="so-autocomplete" id="demo-async-autocomplete"></div>
                    <small class="so-form-text so-text-muted">Type at least 2 characters to search. Results are simulated with a 500ms delay.</small>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('autocomplete-remote', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$autocomplete = UiEngine::autocomplete('product')
    ->label('Search Products')
    ->placeholder('Type to search products...')
    ->async('/api/products/search')
    ->minLength(2)
    ->debounce(300);

echo \$autocomplete->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const autocomplete = UiEngine.autocomplete('product')
    .placeholder('Type to search products...')
    .async(async (query) => {
        const response = await fetch(`/api/products/search?q=\${query}`);
        return await response.json();
    })
    .minLength(2)
    .debounce(300);

document.getElementById('demo-container').appendChild(autocomplete.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-autocomplete" id="product" data-so-async="/api/products/search">
    <div class="so-autocomplete-container">
        <input type="text" class="so-autocomplete-input"
               placeholder="Type to search products..."
               autocomplete="off" role="combobox">
        <button type="button" class="so-autocomplete-clear"
                style="display: none;" aria-label="Clear all">
            <span class="material-icons">close</span>
        </button>
        <span class="so-autocomplete-arrow">
            <span class="material-icons">expand_more</span>
        </span>
    </div>
    <div class="so-autocomplete-dropdown" role="listbox">
        <div class="so-autocomplete-loading" style="display: none;">
            <span class="so-spinner so-spinner-sm"></span>
            <span>Loading...</span>
        </div>
        <div class="so-autocomplete-options"></div>
        <div class="so-autocomplete-no-results" style="display: none;">
            No results found
        </div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Free Solo Mode -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Free Solo Mode</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group so-mb-4">
                    <label class="so-form-label">Email Addresses</label>
                    <div class="so-autocomplete" id="demo-freesolo-autocomplete"></div>
                    <small class="so-form-text so-text-muted">Type an email and press Enter, comma, or semicolon to add. Only valid emails are accepted.</small>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('autocomplete-freesolo', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Allow custom values (free solo mode)
\$autocomplete = UiEngine::autocomplete('emails')
    ->label('Email Addresses')
    ->placeholder('Type email and press Enter...')
    ->multiple()
    ->freeSolo()
    ->tokenDelimiters([',', ';', ' ']);

echo \$autocomplete->renderGroup();

// Note: Token validation is handled via JavaScript
// using the tokenValidation option in SOAutocomplete"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const autocomplete = UiEngine.autocomplete('emails')
    .placeholder('Type email and press Enter...')
    .multiple()
    .freeSolo()
    .tokenDelimiters([',', ';', ' '])
    .tokenValidation((value) => {
        const emailRegex = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
        return emailRegex.test(value);
    });

document.getElementById('demo-container').appendChild(autocomplete.render());"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-autocomplete so-autocomplete-multiple so-autocomplete-display-chips"
     id="emails" data-so-multiple="true" data-so-free-solo="true">
    <div class="so-autocomplete-container">
        <div class="so-autocomplete-tokens">
            <!-- Tokens appear here dynamically when added -->
            <span class="so-autocomplete-token so-chip so-chip-sm">
                <span class="so-autocomplete-token-text">user@example.com</span>
                <button class="so-autocomplete-token-remove so-chip-close">
                    <span class="material-icons">close</span>
                </button>
            </span>
            <input type="text" class="so-autocomplete-input"
                   placeholder="Type email and press Enter..."
                   autocomplete="off" role="combobox">
        </div>
        <button type="button" class="so-autocomplete-clear"
                style="display: none;" aria-label="Clear all">
            <span class="material-icons">close</span>
        </button>
        <span class="so-autocomplete-arrow">
            <span class="material-icons">expand_more</span>
        </span>
    </div>
    <div class="so-autocomplete-dropdown" role="listbox">
        <div class="so-autocomplete-options"></div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Size Variants -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-row so-mb-4">
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Small</label>
                            <div class="so-autocomplete" id="demo-size-sm"></div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Default</label>
                            <div class="so-autocomplete" id="demo-size-default"></div>
                        </div>
                    </div>
                    <div class="so-col-md-4">
                        <div class="so-form-group">
                            <label class="so-form-label">Large</label>
                            <div class="so-autocomplete" id="demo-size-lg"></div>
                        </div>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('autocomplete-sizes', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Small
UiEngine::autocomplete('small')->size('sm');

// Default
UiEngine::autocomplete('default');

// Large
UiEngine::autocomplete('large')->size('lg');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Small
UiEngine.autocomplete('small').size('sm');

// Default
UiEngine.autocomplete('default');

// Large
UiEngine.autocomplete('large').size('lg');"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Small -->
<div class="so-autocomplete so-autocomplete-sm" data-so-autocomplete></div>

<!-- Default -->
<div class="so-autocomplete" data-so-autocomplete></div>

<!-- Large -->
<div class="so-autocomplete so-autocomplete-lg" data-so-autocomplete></div>'
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
                    <button class="so-tab" role="tab" data-so-target="#api-js-uiengine">JS UiEngine</button>
                    <button class="so-tab" role="tab" data-so-target="#api-js-component">SOAutocomplete</button>
                </div>

                <div class="so-tab-content">
                    <!-- PHP Class Reference -->
                    <div class="so-tab-pane so-fade so-show so-active" id="api-php" role="tabpanel">
                        <p class="so-text-secondary so-mb-3"><code>Core\UiEngine\Elements\Form\Autocomplete</code></p>

                        <h5 class="so-mt-4 so-mb-3">Fluent Methods</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Method</th><th>Parameters</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td><code>options()</code></td><td><code>array $options</code></td><td>Set static options array <code>[['value'=>'x','text'=>'X'],...]</code></td></tr>
                                    <tr><td><code>addOption()</code></td><td><code>string|array $option</code></td><td>Add a single option</td></tr>
                                    <tr><td><code>async()</code></td><td><code>string $url</code></td><td>Set remote data URL</td></tr>
                                    <tr><td><code>ajaxUrl()</code></td><td><code>string $url</code></td><td>Alias for async()</td></tr>
                                    <tr><td><code>minLength()</code></td><td><code>int $length</code></td><td>Minimum characters before search (default: 0)</td></tr>
                                    <tr><td><code>minChars()</code></td><td><code>int $chars</code></td><td>Alias for minLength()</td></tr>
                                    <tr><td><code>debounce()</code></td><td><code>int $ms</code></td><td>Debounce delay in ms (default: 300)</td></tr>
                                    <tr><td><code>maxResults()</code></td><td><code>int $max</code></td><td>Maximum results to display (default: 10)</td></tr>
                                    <tr><td><code>multiple()</code></td><td><code>bool $multiple = true</code></td><td>Enable multiple selection with tokens</td></tr>
                                    <tr><td><code>freeSolo()</code></td><td><code>bool $freeSolo = true</code></td><td>Allow custom values not in options</td></tr>
                                    <tr><td><code>strict()</code></td><td>-</td><td>Disable free solo (require selection from list)</td></tr>
                                    <tr><td><code>displayMode()</code></td><td><code>string $mode</code></td><td><code>'chips'</code>, <code>'text'</code>, or <code>'chips-overflow'</code></td></tr>
                                    <tr><td><code>maxVisibleTokens()</code></td><td><code>int $max</code></td><td>Max visible tokens before "+N more" (default: 3)</td></tr>
                                    <tr><td><code>tokenDelimiters()</code></td><td><code>array $delimiters</code></td><td>Characters that create tokens (default: [',', ';'])</td></tr>
                                    <tr><td><code>highlightMatches()</code></td><td><code>bool $highlight = true</code></td><td>Highlight matching text in results</td></tr>
                                    <tr><td><code>highlight()</code></td><td><code>bool $highlight = true</code></td><td>Alias for highlightMatches()</td></tr>
                                    <tr><td><code>clearable()</code></td><td><code>bool $clearable = true</code></td><td>Show clear button</td></tr>
                                    <tr><td><code>noResultsText()</code></td><td><code>string $text</code></td><td>Text when no results found</td></tr>
                                    <tr><td><code>loadingText()</code></td><td><code>string $text</code></td><td>Text during loading</td></tr>
                                    <tr><td><code>itemTemplate()</code></td><td><code>string $template</code></td><td>Custom item template</td></tr>
                                    <tr><td><code>size()</code></td><td><code>string $size</code></td><td>Size variant: <code>'sm'</code> or <code>'lg'</code></td></tr>
                                    <tr><td><code>placeholder()</code></td><td><code>string $text</code></td><td>Input placeholder text</td></tr>
                                    <tr><td><code>disabled()</code></td><td><code>bool $disabled = true</code></td><td>Disable the autocomplete</td></tr>
                                    <tr><td><code>readonly()</code></td><td><code>bool $readonly = true</code></td><td>Make input readonly</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mt-4 so-mb-3">Render Methods</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Method</th><th>Returns</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td><code>render()</code></td><td><code>string</code></td><td>Render the autocomplete HTML</td></tr>
                                    <tr><td><code>renderGroup()</code></td><td><code>string</code></td><td>Render with label, help text, errors</td></tr>
                                    <tr><td><code>toArray()</code></td><td><code>array</code></td><td>Export configuration as array</td></tr>
                                    <tr><td><code>toJson()</code></td><td><code>string</code></td><td>Export configuration as JSON</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- JS UiEngine Class Reference -->
                    <div class="so-tab-pane so-fade" id="api-js-uiengine" role="tabpanel">
                        <p class="so-text-secondary so-mb-3"><code>UiEngine.autocomplete(name)</code> - Fluent builder for HTML generation</p>

                        <h5 class="so-mt-4 so-mb-3">Fluent Methods</h5>
                        <p class="so-text-muted so-mb-2">All methods from PHP class are available with identical signatures:</p>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Method</th><th>Parameters</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td><code>options()</code></td><td><code>array</code></td><td>Set static options</td></tr>
                                    <tr><td><code>addOption()</code></td><td><code>object</code></td><td>Add single option</td></tr>
                                    <tr><td><code>async()</code></td><td><code>string</code></td><td>Set remote URL</td></tr>
                                    <tr><td><code>minLength()</code></td><td><code>number</code></td><td>Min chars before search</td></tr>
                                    <tr><td><code>debounce()</code></td><td><code>number</code></td><td>Debounce delay (ms)</td></tr>
                                    <tr><td><code>multiple()</code></td><td><code>boolean</code></td><td>Enable multi-select</td></tr>
                                    <tr><td><code>freeSolo()</code></td><td><code>boolean</code></td><td>Allow custom values</td></tr>
                                    <tr><td><code>displayMode()</code></td><td><code>string</code></td><td>Token display mode</td></tr>
                                    <tr><td><code>maxVisibleTokens()</code></td><td><code>number</code></td><td>Max visible tokens</td></tr>
                                    <tr><td><code>tokenDelimiters()</code></td><td><code>array</code></td><td>Token delimiters</td></tr>
                                    <tr><td><code>clearable()</code></td><td><code>boolean</code></td><td>Show clear button</td></tr>
                                    <tr><td><code>size()</code></td><td><code>string</code></td><td>Size variant</td></tr>
                                    <tr><td><code>placeholder()</code></td><td><code>string</code></td><td>Placeholder text</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mt-4 so-mb-3">Render Methods</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Method</th><th>Returns</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td><code>toHtml()</code></td><td><code>string</code></td><td>Generate HTML string</td></tr>
                                    <tr><td><code>toConfig()</code></td><td><code>object</code></td><td>Export configuration object</td></tr>
                                    <tr><td><code>toJson()</code></td><td><code>string</code></td><td>Export as JSON string</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SOAutocomplete Component Reference -->
                    <div class="so-tab-pane so-fade" id="api-js-component" role="tabpanel">
                        <p class="so-text-secondary so-mb-3"><code>SOAutocomplete</code> - Interactive component with full functionality</p>

                        <h5 class="so-mt-4 so-mb-3">Constructor</h5>
                        <?= so_code_tabs('autocomplete-constructor', [
                            ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript',
                             'code' => "// Create from selector or element
const autocomplete = new SOAutocomplete('#my-autocomplete', {
    placeholder: 'Search...',
    multiple: true,
    freeSolo: false,
    options: [
        { value: '1', text: 'Option 1' },
        { value: '2', text: 'Option 2', disabled: true },
        { value: '3', text: 'Option 3', group: 'Group A' }
    ],
    async: '/api/search',      // or async function
    minSearchLength: 2,
    debounceTime: 300,
    size: 'lg',                // 'sm' | 'lg' | null
    displayMode: 'chips',      // 'chips' | 'text' | 'chips-overflow'
    maxVisibleTokens: 3,
    tokenDelimiters: [',', ';'],
    tokenValidation: (val) => val.includes('@'),  // for emails
    highlightMatches: true,
    clearable: true,
    closeOnSelect: true,
    maxSelections: 5,
    minSelections: 1
});"]
                        ]) ?>

                        <h5 class="so-mt-4 so-mb-3">Public Methods</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Method</th><th>Parameters</th><th>Returns</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr class="so-table-info"><td colspan="4"><strong>Dropdown Control</strong></td></tr>
                                    <tr><td><code>open()</code></td><td>-</td><td><code>void</code></td><td>Open dropdown</td></tr>
                                    <tr><td><code>close()</code></td><td>-</td><td><code>void</code></td><td>Close dropdown</td></tr>
                                    <tr><td><code>toggle()</code></td><td>-</td><td><code>void</code></td><td>Toggle dropdown</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Value Management</strong></td></tr>
                                    <tr><td><code>getValue()</code></td><td>-</td><td><code>any</code></td><td>Get selected value (single mode)</td></tr>
                                    <tr><td><code>getValues()</code></td><td>-</td><td><code>array</code></td><td>Get all selected values (multiple mode)</td></tr>
                                    <tr><td><code>setValue()</code></td><td><code>value</code></td><td><code>void</code></td><td>Set selected value</td></tr>
                                    <tr><td><code>setValues()</code></td><td><code>array values</code></td><td><code>void</code></td><td>Set multiple values</td></tr>
                                    <tr><td><code>clear()</code></td><td>-</td><td><code>void</code></td><td>Clear all selections</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Token Management (Multiple Mode)</strong></td></tr>
                                    <tr><td><code>getTokens()</code></td><td>-</td><td><code>array</code></td><td>Get all tokens</td></tr>
                                    <tr><td><code>addToken()</code></td><td><code>value, text?</code></td><td><code>void</code></td><td>Add a token</td></tr>
                                    <tr><td><code>removeToken()</code></td><td><code>index</code></td><td><code>void</code></td><td>Remove token by index</td></tr>
                                    <tr><td><code>removeTokenByValue()</code></td><td><code>value</code></td><td><code>void</code></td><td>Remove token by value</td></tr>
                                    <tr><td><code>clearTokens()</code></td><td>-</td><td><code>void</code></td><td>Remove all tokens</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Options Management</strong></td></tr>
                                    <tr><td><code>setOptions()</code></td><td><code>array options</code></td><td><code>void</code></td><td>Replace all options</td></tr>
                                    <tr><td><code>addOption()</code></td><td><code>object option</code></td><td><code>void</code></td><td>Add single option</td></tr>
                                    <tr><td><code>addOptions()</code></td><td><code>array options</code></td><td><code>void</code></td><td>Add multiple options</td></tr>
                                    <tr><td><code>removeOption()</code></td><td><code>value</code></td><td><code>void</code></td><td>Remove option by value</td></tr>
                                    <tr><td><code>clearOptions()</code></td><td>-</td><td><code>void</code></td><td>Remove all options</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>State Control</strong></td></tr>
                                    <tr><td><code>enable()</code></td><td>-</td><td><code>void</code></td><td>Enable the autocomplete</td></tr>
                                    <tr><td><code>disable()</code></td><td>-</td><td><code>void</code></td><td>Disable the autocomplete</td></tr>
                                    <tr><td><code>clearInput()</code></td><td>-</td><td><code>void</code></td><td>Clear input text only</td></tr>
                                    <tr><td><code>focus()</code></td><td>-</td><td><code>void</code></td><td>Focus the input</td></tr>
                                    <tr><td><code>blur()</code></td><td>-</td><td><code>void</code></td><td>Remove focus</td></tr>
                                    <tr><td><code>destroy()</code></td><td>-</td><td><code>void</code></td><td>Destroy instance and cleanup</td></tr>
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
                                    <tr class="so-table-info"><td colspan="3"><strong>Dropdown Events</strong></td></tr>
                                    <tr><td><code>so:autocomplete:open</code></td><td>-</td><td>Before dropdown opens (cancelable)</td></tr>
                                    <tr><td><code>so:autocomplete:opened</code></td><td>-</td><td>After dropdown opened</td></tr>
                                    <tr><td><code>so:autocomplete:close</code></td><td>-</td><td>Before dropdown closes (cancelable)</td></tr>
                                    <tr><td><code>so:autocomplete:closed</code></td><td>-</td><td>After dropdown closed</td></tr>

                                    <tr class="so-table-info"><td colspan="3"><strong>Selection Events</strong></td></tr>
                                    <tr><td><code>so:autocomplete:select</code></td><td><code>{ value, text, item, index }</code></td><td>Option selected</td></tr>
                                    <tr><td><code>so:autocomplete:deselect</code></td><td><code>{ value, text, item, index }</code></td><td>Option deselected (multiple mode)</td></tr>
                                    <tr><td><code>so:autocomplete:change</code></td><td><code>{ value, values, text, texts }</code></td><td>Selection changed</td></tr>

                                    <tr class="so-table-info"><td colspan="3"><strong>Token Events (Multiple Mode)</strong></td></tr>
                                    <tr><td><code>so:autocomplete:token-add</code></td><td><code>{ token, tokens }</code></td><td>Token added</td></tr>
                                    <tr><td><code>so:autocomplete:token-remove</code></td><td><code>{ token, tokens, index }</code></td><td>Token removed</td></tr>

                                    <tr class="so-table-info"><td colspan="3"><strong>Input/Data Events</strong></td></tr>
                                    <tr><td><code>so:autocomplete:input</code></td><td><code>{ query }</code></td><td>Input value changed</td></tr>
                                    <tr><td><code>so:autocomplete:search</code></td><td><code>{ query, count }</code></td><td>Search triggered</td></tr>
                                    <tr><td><code>so:autocomplete:clear</code></td><td>-</td><td>Cleared all selections</td></tr>
                                    <tr><td><code>so:autocomplete:create</code></td><td><code>{ value, text }</code></td><td>Custom value created (free solo)</td></tr>

                                    <tr class="so-table-info"><td colspan="3"><strong>Async Events</strong></td></tr>
                                    <tr><td><code>so:autocomplete:load-start</code></td><td><code>{ query }</code></td><td>Async loading started</td></tr>
                                    <tr><td><code>so:autocomplete:load-end</code></td><td><code>{ data, query, count }</code></td><td>Async loading completed</td></tr>
                                    <tr><td><code>so:autocomplete:load-error</code></td><td><code>{ error, query }</code></td><td>Async loading failed</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="so-mt-4 so-mb-3">Event Usage Example</h5>
                        <?= so_code_tabs('autocomplete-events', [
                            ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript',
                             'code' => "const ac = new SOAutocomplete('#search', { multiple: true });

// Listen for selection changes
ac.element.addEventListener('so:autocomplete:change', (e) => {
    console.log('Selected values:', e.detail.values);
    console.log('Selected texts:', e.detail.texts);
});

// Listen for token events
ac.element.addEventListener('so:autocomplete:token-add', (e) => {
    console.log('Token added:', e.detail.token);
    console.log('All tokens:', e.detail.tokens);
});

ac.element.addEventListener('so:autocomplete:token-remove', (e) => {
    console.log('Token removed:', e.detail.token);
    console.log('Removed at index:', e.detail.index);
});

// Listen for async loading
ac.element.addEventListener('so:autocomplete:load-start', (e) => {
    console.log('Loading for query:', e.detail.query);
});

ac.element.addEventListener('so:autocomplete:load-end', (e) => {
    console.log('Loaded', e.detail.count, 'options for:', e.detail.query);
});

ac.element.addEventListener('so:autocomplete:load-error', (e) => {
    console.error('Load failed:', e.detail.error);
});

// Programmatic control
ac.setValue('option-1');      // Single mode
ac.setValues(['a', 'b']);     // Multiple mode
ac.addToken('new@email.com'); // Add token
ac.clear();                   // Clear all
ac.disable();                 // Disable
ac.enable();                  // Enable"]
                        ]) ?>

                        <h5 class="so-mt-4 so-mb-3">Inherited Methods (from SOComponent)</h5>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr><th>Method</th><th>Parameters</th><th>Returns</th><th>Description</th></tr>
                                </thead>
                                <tbody>
                                    <tr class="so-table-info"><td colspan="4"><strong>Class Manipulation</strong></td></tr>
                                    <tr><td><code>addClass()</code></td><td><code>...classes</code></td><td><code>this</code></td><td>Add CSS class(es) to the element</td></tr>
                                    <tr><td><code>removeClass()</code></td><td><code>...classes</code></td><td><code>this</code></td><td>Remove CSS class(es) from the element</td></tr>
                                    <tr><td><code>toggleClass()</code></td><td><code>className, force?</code></td><td><code>this</code></td><td>Toggle a CSS class</td></tr>
                                    <tr><td><code>hasClass()</code></td><td><code>className</code></td><td><code>boolean</code></td><td>Check if element has a class</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Data Attributes</strong></td></tr>
                                    <tr><td><code>getData()</code></td><td><code>name</code></td><td><code>string|null</code></td><td>Get data-so-* attribute value</td></tr>
                                    <tr><td><code>setData()</code></td><td><code>name, value</code></td><td><code>this</code></td><td>Set data-so-* attribute value</td></tr>
                                    <tr><td><code>removeData()</code></td><td><code>name</code></td><td><code>this</code></td><td>Remove data-so-* attribute</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Event Management</strong></td></tr>
                                    <tr><td><code>on()</code></td><td><code>event, handler, target?, options?</code></td><td><code>this</code></td><td>Add event listener</td></tr>
                                    <tr><td><code>off()</code></td><td><code>event, handler, target?</code></td><td><code>this</code></td><td>Remove event listener</td></tr>
                                    <tr><td><code>once()</code></td><td><code>event, handler, target?</code></td><td><code>this</code></td><td>Add one-time event listener</td></tr>
                                    <tr><td><code>emit()</code></td><td><code>name, detail?, bubbles?, cancelable?</code></td><td><code>boolean</code></td><td>Emit custom event (auto-prefixed with so:)</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Visibility</strong></td></tr>
                                    <tr><td><code>show()</code></td><td>-</td><td><code>this</code></td><td>Show the component</td></tr>
                                    <tr><td><code>hide()</code></td><td>-</td><td><code>this</code></td><td>Hide the component</td></tr>
                                    <tr><td><code>isVisible()</code></td><td>-</td><td><code>boolean</code></td><td>Check if visible</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Options</strong></td></tr>
                                    <tr><td><code>setOptions()</code></td><td><code>newOptions</code></td><td><code>this</code></td><td>Update component options</td></tr>

                                    <tr class="so-table-info"><td colspan="4"><strong>Static Methods</strong></td></tr>
                                    <tr><td><code>getInstance()</code></td><td><code>element, options?</code></td><td><code>SOAutocomplete</code></td><td>Get or create instance for element</td></tr>
                                    <tr><td><code>initAll()</code></td><td><code>selector?, options?</code></td><td><code>array</code></td><td>Initialize all matching elements</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Validation -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Autocomplete supports validation through PHP rules and JavaScript token validation.</p>

                <h5 class="so-mt-4 so-mb-3">PHP Validation Rules</h5>
                <?= so_code_tabs('autocomplete-validation-php', [
                    ['label' => 'PHP', 'language' => 'php', 'icon' => 'data_object',
                     'code' => "// Basic required validation
\$autocomplete = UiEngine::autocomplete('category')
    ->label('Category')
    ->required('Please select a category');

// With multiple validation rules
\$autocomplete = UiEngine::autocomplete('tags')
    ->label('Tags')
    ->multiple()
    ->required()
    ->min(1, 'Select at least one tag')
    ->max(5, 'Maximum 5 tags allowed');

// Custom validation with pattern
\$autocomplete = UiEngine::autocomplete('email_list')
    ->label('Email Recipients')
    ->multiple()
    ->freeSolo()
    ->rules('required|email')
    ->messages([
        'required' => 'At least one email is required',
        'email' => 'Please enter valid email addresses'
    ]);

// Export validation for JavaScript
\$validationConfig = \$autocomplete->exportValidation();
// Returns: ['rules' => [...], 'messages' => [...]]"]
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">JavaScript Token Validation</h5>
                <?= so_code_tabs('autocomplete-validation-js', [
                    ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript',
                     'code' => "// Email validation for free solo mode
const emailAutocomplete = UiEngine.autocomplete('emails')
    .multiple()
    .freeSolo()
    .tokenValidation((value) => {
        const emailRegex = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
        return emailRegex.test(value);
    });

// Custom validation with feedback
const tagAutocomplete = UiEngine.autocomplete('tags')
    .multiple()
    .freeSolo()
    .minSelections(1)
    .maxSelections(5)
    .tokenValidation((value) => {
        // Must be 2-20 characters, alphanumeric and hyphens only
        return /^[a-zA-Z0-9-]{2,20}$/.test(value);
    });

// Render and get element for event listening
const tagElement = tagAutocomplete.render();
document.getElementById('demo-container').appendChild(tagElement);

// Listen for validation-related events
tagElement.addEventListener('so:autocomplete:create', (e) => {
    console.log('New tag created:', e.detail.value);
});

// Check selection count
tagElement.addEventListener('so:autocomplete:change', (e) => {
    const count = e.detail.values.length;
    if (count < 1) {
        showError('At least one tag is required');
    } else if (count > 5) {
        showError('Maximum 5 tags allowed');
    } else {
        clearError();
    }
});"]
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Available Validation Rules (PHP)</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered so-table-sm">
                        <thead class="so-table-light">
                            <tr><th>Rule</th><th>Parameters</th><th>Description</th></tr>
                        </thead>
                        <tbody>
                            <tr><td><code>required</code></td><td>-</td><td>Field must have a value</td></tr>
                            <tr><td><code>min</code></td><td><code>int</code></td><td>Minimum selections (multiple mode)</td></tr>
                            <tr><td><code>max</code></td><td><code>int</code></td><td>Maximum selections (multiple mode)</td></tr>
                            <tr><td><code>email</code></td><td>-</td><td>Values must be valid emails (free solo)</td></tr>
                            <tr><td><code>in</code></td><td><code>array</code></td><td>Value must be in predefined list</td></tr>
                            <tr><td><code>regex</code></td><td><code>string</code></td><td>Value must match pattern</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Error Handling -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Error Handling</h3>
            </div>
            <div class="so-card-body">
                <h5 class="so-mt-4 so-mb-3">Displaying Errors (PHP)</h5>
                <?= so_code_tabs('autocomplete-errors-php', [
                    ['label' => 'PHP', 'language' => 'php', 'icon' => 'data_object',
                     'code' => "// Set error message from server-side validation
\$autocomplete = UiEngine::autocomplete('category')
    ->label('Category')
    ->error('Please select a valid category');

// Render with error displayed
echo \$autocomplete->renderGroup();
// This adds 'so-is-invalid' class and shows error message

// Check if has error
if (\$autocomplete->hasError()) {
    // Handle error state
}

// Get error message
\$errorMessage = \$autocomplete->getError();"]
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Handling Async Errors (JavaScript)</h5>
                <?= so_code_tabs('autocomplete-errors-js', [
                    ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript',
                     'code' => "const autocomplete = UiEngine.autocomplete('search')
    .async('/api/search');

const element = autocomplete.render();
document.getElementById('demo-container').appendChild(element);

// Handle loading errors
element.addEventListener('so:autocomplete:load-error', (e) => {
    const { error, query } = e.detail;

    // Show user-friendly error message
    showToast('Failed to load results. Please try again.', 'error');

    // Log detailed error for debugging
    console.error('Search failed for query:', query, error);

    // Optionally retry
    setTimeout(() => {
        autocomplete.filterOptions(query);
    }, 2000);
});

// Manual error handling with custom async
const customAutocomplete = UiEngine.autocomplete('custom-search')
    .options([]);

const customElement = customAutocomplete.render();
document.getElementById('demo-container').appendChild(customElement);

// Get component instance for manual control
const customInstance = SOAutocomplete.getInstance(customElement);

async function searchProducts(query) {
    try {
        customInstance.setLoading(true);

        const response = await fetch(`/api/products?q=\${query}`);

        if (!response.ok) {
            throw new Error(`HTTP \${response.status}`);
        }

        const data = await response.json();
        customInstance.setOptions(data.results);

    } catch (error) {
        // Handle specific error types
        if (error.name === 'AbortError') {
            // Request was cancelled, ignore
            return;
        }

        // Network error
        if (!navigator.onLine) {
            showError('No internet connection');
        } else {
            showError('Search failed. Please try again.');
        }

        customInstance.clearOptions();

    } finally {
        customInstance.setLoading(false);
    }
}"]
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Error States CSS Classes</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered so-table-sm">
                        <thead class="so-table-light">
                            <tr><th>Class</th><th>Applied When</th><th>Description</th></tr>
                        </thead>
                        <tbody>
                            <tr><td><code>so-is-invalid</code></td><td>Validation fails</td><td>Red border, shows error message</td></tr>
                            <tr><td><code>so-is-valid</code></td><td>Validation passes</td><td>Green border, success state</td></tr>
                            <tr><td><code>so-autocomplete-loading</code></td><td>Loading async data</td><td>Shows loading spinner</td></tr>
                            <tr><td><code>so-autocomplete-disabled</code></td><td>Component disabled</td><td>Grayed out, non-interactive</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PHP to JS Configuration -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">PHP to JavaScript Configuration</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-secondary so-mb-4">Pass configuration from PHP to JavaScript for dynamic initialization.</p>

                <h5 class="so-mt-4 so-mb-3">Export Configuration</h5>
                <?= so_code_tabs('autocomplete-php-to-js', [
                    ['label' => 'PHP', 'language' => 'php', 'icon' => 'data_object',
                     'code' => "// Build autocomplete in PHP
\$autocomplete = UiEngine::autocomplete('products')
    ->label('Select Products')
    ->multiple()
    ->async('/api/products/search')
    ->minLength(2)
    ->debounce(300)
    ->maxVisibleTokens(3)
    ->displayMode('chips-overflow')
    ->required()
    ->messages(['required' => 'Please select at least one product']);

// Export as array
\$config = \$autocomplete->toArray();

// Export as JSON for JavaScript
\$jsonConfig = \$autocomplete->toJson();

// Export validation separately
\$validation = \$autocomplete->exportValidation();"],
                    ['label' => 'JavaScript', 'language' => 'javascript', 'icon' => 'javascript',
                     'code' => "// Initialize with PHP configuration using UiEngine.fromConfig()
const config = <?= \$autocomplete->toJson() ?>;
const autocomplete = UiEngine.fromConfig(config);
document.getElementById('container').appendChild(autocomplete.render());

// Or use data attributes (auto-parsed)
// PHP renders: data-so-multiple=\"true\" data-so-async=\"/api/search\"
// UiEngine automatically reads these via data attributes

// Apply validation from PHP
const validation = <?= json_encode(\$autocomplete->exportValidation()) ?>;
if (validation.rules.required) {
    // Set up required validation in JS
}

// Dynamic initialization with server data
fetch('/api/autocomplete-config/products')
    .then(res => res.json())
    .then(config => {
        const ac = UiEngine.fromConfig({
            ...config,
            // Override or add JS-specific options
            tokenValidation: (val) => val.length >= 2
        });
    });"]
                ]) ?>

                <h5 class="so-mt-4 so-mb-3">Data Attribute Mapping</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered so-table-sm">
                        <thead class="so-table-light">
                            <tr><th>PHP Method</th><th>Data Attribute</th><th>JS Option</th></tr>
                        </thead>
                        <tbody>
                            <tr><td><code>multiple()</code></td><td><code>data-so-multiple</code></td><td><code>multiple</code></td></tr>
                            <tr><td><code>freeSolo()</code></td><td><code>data-so-free-solo</code></td><td><code>freeSolo</code></td></tr>
                            <tr><td><code>async()</code></td><td><code>data-so-async</code></td><td><code>asyncUrl</code></td></tr>
                            <tr><td><code>minLength()</code></td><td><code>data-so-min-length</code></td><td><code>minSearchLength</code></td></tr>
                            <tr><td><code>debounce()</code></td><td><code>data-so-debounce</code></td><td><code>debounceTime</code></td></tr>
                            <tr><td><code>displayMode()</code></td><td><code>data-so-display-mode</code></td><td><code>displayMode</code></td></tr>
                            <tr><td><code>maxVisibleTokens()</code></td><td><code>data-so-max-visible-tokens</code></td><td><code>maxVisibleTokens</code></td></tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4 so-mb-3">Complete Integration Example</h5>
                <?= so_code_tabs('autocomplete-integration', [
                    ['label' => 'PHP Controller', 'language' => 'php', 'icon' => 'data_object',
                     'code' => "// In your controller
class ProductController
{
    public function create()
    {
        \$categoryAutocomplete = UiEngine::autocomplete('category_id')
            ->label('Category')
            ->async('/api/categories/search')
            ->minLength(1)
            ->required();

        \$tagsAutocomplete = UiEngine::autocomplete('tags')
            ->label('Tags')
            ->multiple()
            ->freeSolo()
            ->options(\$this->getPopularTags())
            ->maxVisibleTokens(5);

        return view('products.create', [
            'categoryAutocomplete' => \$categoryAutocomplete,
            'tagsAutocomplete' => \$tagsAutocomplete,
        ]);
    }
}"],
                    ['label' => 'View Template', 'language' => 'php', 'icon' => 'code',
                     'code' => "<!-- In your view -->
<form method=\"POST\" action=\"/products\">
    <?= \$categoryAutocomplete->renderGroup() ?>
    <?= \$tagsAutocomplete->renderGroup() ?>

    <button type=\"submit\" class=\"so-btn so-btn-primary\">
        Create Product
    </button>
</form>

<script>
// Auto-initialize from data attributes
document.addEventListener('DOMContentLoaded', () => {
    SOAutocomplete.initAll('[data-so-autocomplete]');
});
</script>"]
                ]) ?>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Common options for reuse
    const colorOptions = [
        { value: 'red', text: 'Red' },
        { value: 'blue', text: 'Blue' },
        { value: 'green', text: 'Green' },
        { value: 'yellow', text: 'Yellow' },
        { value: 'purple', text: 'Purple' },
        { value: 'orange', text: 'Orange' },
        { value: 'pink', text: 'Pink' },
        { value: 'cyan', text: 'Cyan' }
    ];

    const fruitOptions = [
        { value: 'apple', text: 'Apple' },
        { value: 'banana', text: 'Banana' },
        { value: 'cherry', text: 'Cherry' },
        { value: 'date', text: 'Date' },
        { value: 'elderberry', text: 'Elderberry' },
        { value: 'fig', text: 'Fig' },
        { value: 'grape', text: 'Grape' },
        { value: 'honeydew', text: 'Honeydew' }
    ];

    // Initialize basic autocomplete demo
    if (document.getElementById('demo-basic-autocomplete')) {
        new SOAutocomplete('#demo-basic-autocomplete', {
            placeholder: 'Type to search...',
            options: [
                { value: 'us', text: 'United States' },
                { value: 'uk', text: 'United Kingdom' },
                { value: 'ca', text: 'Canada' },
                { value: 'au', text: 'Australia' },
                { value: 'de', text: 'Germany' },
                { value: 'fr', text: 'France' },
                { value: 'jp', text: 'Japan' },
                { value: 'in', text: 'India' }
            ]
        });
    }

    // Initialize multiple autocomplete demo
    if (document.getElementById('demo-multiple-autocomplete')) {
        new SOAutocomplete('#demo-multiple-autocomplete', {
            placeholder: 'Add skills...',
            multiple: true,
            options: [
                { value: 'js', text: 'JavaScript' },
                { value: 'py', text: 'Python' },
                { value: 'php', text: 'PHP' },
                { value: 'java', text: 'Java' },
                { value: 'ruby', text: 'Ruby' },
                { value: 'go', text: 'Go' },
                { value: 'rust', text: 'Rust' },
                { value: 'ts', text: 'TypeScript' }
            ]
        });
    }

    // Display Modes demos
    if (document.getElementById('demo-display-chips')) {
        new SOAutocomplete('#demo-display-chips', {
            placeholder: 'Select colors...',
            multiple: true,
            displayMode: 'chips',
            options: colorOptions
        });
    }

    if (document.getElementById('demo-display-chips-overflow')) {
        new SOAutocomplete('#demo-display-chips-overflow', {
            placeholder: 'Select colors...',
            multiple: true,
            displayMode: 'chips-overflow',
            maxVisibleTokens: 2,
            options: colorOptions
        });
    }

    if (document.getElementById('demo-display-text')) {
        new SOAutocomplete('#demo-display-text', {
            placeholder: 'Select colors...',
            multiple: true,
            displayMode: 'text',
            options: colorOptions
        });
    }

    // Async/Remote data demo (simulated)
    if (document.getElementById('demo-async-autocomplete')) {
        const productData = [
            { value: 'laptop', text: 'Laptop Pro 15"' },
            { value: 'phone', text: 'Smartphone X' },
            { value: 'tablet', text: 'Tablet Air' },
            { value: 'watch', text: 'Smart Watch' },
            { value: 'headphones', text: 'Wireless Headphones' },
            { value: 'keyboard', text: 'Mechanical Keyboard' },
            { value: 'mouse', text: 'Gaming Mouse' },
            { value: 'monitor', text: 'Ultra HD Monitor' },
            { value: 'speaker', text: 'Bluetooth Speaker' },
            { value: 'camera', text: 'Digital Camera' }
        ];

        new SOAutocomplete('#demo-async-autocomplete', {
            placeholder: 'Type to search products...',
            minSearchLength: 2,
            debounceTime: 300,
            async: true,
            asyncUrl: null, // We'll use custom async function
            options: [], // Start empty
        });

        // Override with custom async behavior using events
        const asyncDemo = document.getElementById('demo-async-autocomplete');
        const asyncInstance = SOAutocomplete.getInstance(asyncDemo);

        // Simulate async search on input
        asyncDemo.addEventListener('so:autocomplete:input', (e) => {
            const query = e.detail.query.toLowerCase();
            if (query.length >= 2) {
                asyncInstance.setLoading(true);
                // Simulate network delay
                setTimeout(() => {
                    const filtered = productData.filter(p =>
                        p.text.toLowerCase().includes(query)
                    );
                    asyncInstance.setOptions(filtered);
                    asyncInstance.setLoading(false);
                }, 500);
            }
        });
    }

    // Free Solo demo
    if (document.getElementById('demo-freesolo-autocomplete')) {
        new SOAutocomplete('#demo-freesolo-autocomplete', {
            placeholder: 'Type email and press Enter...',
            multiple: true,
            freeSolo: true,
            tokenDelimiters: [',', ';'],
            tokenValidation: (value) => {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(value);
            },
            options: [
                { value: 'john@example.com', text: 'john@example.com' },
                { value: 'jane@example.com', text: 'jane@example.com' },
                { value: 'admin@company.com', text: 'admin@company.com' }
            ]
        });
    }

    // Size variants demos
    if (document.getElementById('demo-size-sm')) {
        new SOAutocomplete('#demo-size-sm', {
            placeholder: 'Small size...',
            size: 'sm',
            options: fruitOptions
        });
    }

    if (document.getElementById('demo-size-default')) {
        new SOAutocomplete('#demo-size-default', {
            placeholder: 'Default size...',
            options: fruitOptions
        });
    }

    if (document.getElementById('demo-size-lg')) {
        new SOAutocomplete('#demo-size-lg', {
            placeholder: 'Large size...',
            size: 'lg',
            options: fruitOptions
        });
    }
});
</script>

<?php require_once '../../includes/footer.php'; ?>
