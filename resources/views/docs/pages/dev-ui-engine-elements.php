<?php
/**
 * UiEngine Element Reference
 *
 * Complete API reference for all 49 UiEngine elements.
 */

$pageTitle = 'UiEngine Element Reference';
$pageIcon = 'format-list-bulleted-type';
$toc = [
    ['id' => 'overview', 'title' => 'Overview', 'level' => 2],
    ['id' => 'form-elements', 'title' => 'Form Elements', 'level' => 2],
    ['id' => 'display-elements', 'title' => 'Display Elements', 'level' => 2],
    ['id' => 'navigation-elements', 'title' => 'Navigation Elements', 'level' => 2],
    ['id' => 'layout-elements', 'title' => 'Layout Elements', 'level' => 2],
    ['id' => 'common-methods', 'title' => 'Common Methods', 'level' => 2],
];
$breadcrumbs = [['label' => 'Development', 'url' => '/docs#dev-panel'], ['label' => 'UiEngine Element Reference']];
$lastUpdated = '2026-02-03';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="dev-ui-engine-elements" class="heading heading-1">
    <span class="mdi mdi-format-list-bulleted-type heading-icon"></span>
    <span class="heading-text">UiEngine Element Reference</span>
</h1>

<p class="text-lead">
    Complete API reference for all 49 UiEngine elements. Each element lists its factory method, configuration options, and available methods.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-reference">Reference</span>
    <span class="badge badge-new">New</span>
    <span class="badge badge-api">API</span>
</div>

<!-- Overview -->
<h2 id="overview" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Overview</span>
</h2>

<?= callout('info', '
    <strong>Element Categories:</strong>
    <ul class="so-mb-0">
        <li><strong>Form Elements (17)</strong> - Inputs, selects, buttons, and form containers</li>
        <li><strong>Display Elements (22)</strong> - Cards, modals, tables, alerts, and content components</li>
        <li><strong>Navigation Elements (4)</strong> - Dropdowns, navbars, and menus</li>
        <li><strong>Layout Elements (6)</strong> - Grids, containers, and structural components</li>
    </ul>
') ?>

<!-- Form Elements -->
<h2 id="form-elements" class="heading heading-2">
    <span class="mdi mdi-form-textbox heading-icon"></span>
    <span class="heading-text">Form Elements (17)</span>
</h2>

<h3 class="heading heading-3"><span class="heading-text">Input</span></h3>
<?= codeBlock('php', 'UiEngine::input($name)
    // Input Type
    ->type($type)           // text, email, password, number, tel, url, search, date, time, datetime-local, month, week, color, range
    ->inputType($type)      // Alias for type()

    // Type Shortcut Methods
    ->email()               // type="email"
    ->password()            // type="password"
    ->number()              // type="number"
    ->tel()                 // type="tel"
    ->url()                 // type="url"
    ->search()              // type="search"
    ->date()                // type="date"
    ->time()                // type="time"
    ->datetime()            // type="datetime-local"
    ->month()               // type="month"
    ->week()                // type="week"
    ->color()               // type="color"
    ->range()               // type="range"

    // Content
    ->label($label)
    ->placeholder($text)
    ->value($value)
    ->help($text)           // Help text below input

    // Input Group (prefix/suffix)
    ->prefix($text)         // Text/icon before input
    ->suffix($text)         // Text/icon after input

    // Icons
    ->icon($name)           // Left icon inside input
    ->iconRight($name)      // Right icon inside input

    // Constraints
    ->maxlength($n)         // Maximum character length
    ->minlength($n)         // Minimum character length
    ->min($n)               // Minimum value (number/date)
    ->max($n)               // Maximum value (number/date)
    ->step($n)              // Step increment (number/range)
    ->pattern($regex)       // Regex validation pattern

    // Autocomplete
    ->autocomplete($value)  // Set autocomplete value (name, email, etc.)
    ->noAutocomplete()      // Disable autocomplete

    // States
    ->required()            // Mark as required
    ->disabled()            // Disable input
    ->readonly()            // Read-only state
    ->autofocus()           // Auto-focus on page load

    // Sizing
    ->size($size)           // sm, md, lg
    ->small()               // Small size shortcut
    ->large()               // Large size shortcut

    // Validation (from HasValidation trait)
    ->rules($rules)         // Validation rules array
    ->messages($array)      // Custom error messages
    ->error($message)       // Display error message
    ->clearError()          // Clear error state

    // Event handlers (from HasEvents trait)
    ->onChange($handler)
    ->onInput($handler)
    ->onFocus($handler)
    ->onBlur($handler)
    ->onKeydown($handler)
    ->onKeyup($handler)
    ->on($event, $handler)

    // Rendering
    ->render()              // Render input HTML
    ->renderGroup()         // Render with label, help, error
    ->toArray()             // Export configuration

// Factory convenience methods:
UiEngine::email($name)      // Creates input with type="email"
UiEngine::password($name)   // Creates input with type="password"
UiEngine::number($name)     // Creates input with type="number"
UiEngine::date($name)       // Creates input with type="date"
UiEngine::tel($name)        // Creates input with type="tel"
UiEngine::url($name)        // Creates input with type="url"
UiEngine::search($name)     // Creates input with type="search"') ?>

<p class="so-text-muted so-mt-2 so-mb-3">
    <strong>Note:</strong> When <code>prefix()</code> or <code>suffix()</code> is set, the input renders within an <code>so-input-group</code> wrapper.
    Configuration is passed to JavaScript via <code>data-so-ui-init="input"</code> and <code>data-so-ui-config</code> attributes.
    Validation rules are automatically exported for client-side validation.
</p>

<h3 class="heading heading-3"><span class="heading-text">Select</span></h3>
<?= codeBlock('php', 'UiEngine::select($name)
    ->label($label)
    ->options($array)       // [\'value\' => \'Label\'] or [[\'value\' => \'\', \'label\' => \'\']]
    ->optgroup($label, $options)
    ->placeholder($text)    // Empty first option
    ->value($value)
    ->multiple()
    ->searchable()          // Enable search filter
    ->required()
    ->disabled()
    ->size($size)           // sm, lg
    ->rules($rules)
    ->help($text)') ?>

<h3 class="heading heading-3"><span class="heading-text">Checkbox</span></h3>
<?= codeBlock('php', 'UiEngine::checkbox($name)
    ->label($label)
    ->value($value)         // Value when checked (for single checkbox)
    ->checked($bool)        // Set checked state
    ->unchecked()           // Explicitly set unchecked
    ->switch()              // Render as toggle switch style
    ->inline()              // Display checkboxes inline (for groups)
    ->indeterminate()       // Set indeterminate state (partial selection)
    ->options($array)       // For checkbox group: [\'value\' => \'Label\']
    ->option($val, $label, $checked)  // Add single option to group
    ->required()
    ->disabled()
    ->help($text)           // Help text below checkbox
    ->error($message)       // Validation error message
    ->rules($rules)
    ->messages($array)      // Custom validation messages

// Event handlers (from HasEvents trait)
    ->onChange($handler)
    ->onClick($handler)
    ->on($event, $handler)

// Rendering
    ->render()              // Auto-detects single vs group
    ->renderGroup()         // Render with form group wrapper
    ->toArray()             // Export configuration') ?>

<p class="so-text-muted so-mt-2 so-mb-3">
    <strong>Note:</strong> When <code>options()</code> is set, checkbox renders as a group with <code>name[]</code> array notation.
    The <code>indeterminate()</code> method adds a <code>data-so-indeterminate</code> attribute for JavaScript to detect and apply the visual state.
</p>

<h3 class="heading heading-3"><span class="heading-text">Radio</span></h3>
<?= codeBlock('php', 'UiEngine::radio($name)
    // Options
    ->options($array)       // [[\'value\' => \'val\', \'label\' => \'Label\']] or [\'value\' => \'Label\']
    ->option($value, $label, $disabled)  // Add single option
    ->value($value)         // Pre-selected value

    // Layout
    ->inline(bool $val)     // Display radios inline (horizontal)

    // Button Style
    ->buttonStyle(bool $val)  // Render as button group instead of radios
    ->buttonVariant($var)     // Button color variant (primary, secondary, etc.)

    // Labels & Help
    ->label($label)         // Group label
    ->help($text)           // Help text below group
    ->error($message)       // Display error message

    // States
    ->required()            // Mark as required
    ->disabled()            // Disable all radios
    ->readonly()            // Read-only state

    // Validation
    ->rules($rules)         // Validation rules array
    ->messages($array)      // Custom error messages

    // Event handlers (from HasEvents trait)
    ->onChange($handler)
    ->onClick($handler)
    ->onFocus($handler)
    ->onBlur($handler)
    ->on($event, $handler)

    // Rendering
    ->render()              // Render radio group HTML
    ->renderGroup()         // Render with label, help, error
    ->toArray()             // Export configuration

// Events (JavaScript): change, click, focus, blur (standard DOM events)') ?>

<p class="so-text-muted so-mt-2 so-mb-3">
    <strong>Note:</strong> Radio renders with CSS classes <code>so-radio</code> (wrapper label), <code>so-radio-circle</code> (visual indicator), <code>so-radio-label</code> (text).
    Groups use <code>so-radio-group</code> with <code>so-radio-group-vertical</code> or <code>so-radio-group-inline</code>.
    When <code>buttonStyle()</code> is enabled, renders as <code>so-btn-group</code> with <code>so-btn-check</code> inputs.
    Radio uses standard DOM events (no <code>so:</code> prefix) since it wraps native input elements.
</p>

<h3 class="heading heading-3"><span class="heading-text">Textarea</span></h3>
<?= codeBlock('php', 'UiEngine::textarea($name)
    ->label($label)
    ->placeholder($text)
    ->value($value)
    ->rows($n)
    ->maxlength($n)
    ->showCounter()         // Character count display
    ->autoResize()          // Auto-grow height
    ->required()
    ->disabled()
    ->rules($rules)
    ->help($text)') ?>

<h3 class="heading heading-3"><span class="heading-text">Button</span></h3>
<?= codeBlock('php', 'UiEngine::button($text)
    // Button type
    ->buttonType($type)     // button, submit, reset
    ->submit()              // Set type="submit"
    ->reset()               // Set type="reset"
    ->text($text)           // Change button text

    // Variants (colors)
    ->variant($variant)     // primary, secondary, success, danger, warning, info, light, dark, link
    ->primary()             // Blue primary button
    ->secondary()           // Gray secondary button
    ->success()             // Green success button
    ->danger()              // Red danger button
    ->warning()             // Yellow warning button
    ->info()                // Cyan info button
    ->light()               // Light gray button
    ->dark()                // Dark button
    ->link()                // Link-style button

    // Styling
    ->outline()             // Outline/ghost style (transparent background)
    ->size($size)           // sm, md, lg
    ->small()               // Small size shortcut
    ->large()               // Large size shortcut
    ->block()               // Full width (w-100)

    // Icons
    ->icon($name, $pos)     // Icon with position (left/right)
    ->iconOnly($name)       // Icon-only button (no text, square)

    // States
    ->disabled()            // Disabled state
    ->loading($bool, $text) // Loading state with optional loading text

    // Link button (renders as <a>)
    ->href($url, $target)   // Render as anchor tag
    ->newTab()              // Open in new tab (_blank)

    // Event handlers (from HasEvents trait)
    ->onClick($handler)
    ->on($event, $handler)
    ->onMany($events)

    // Rendering
    ->render()              // Returns HTML string
    ->toArray()             // Export configuration

// Convenience factory methods:
UiEngine::submit($text)     // type="submit" + primary variant
UiEngine::reset($text)      // type="reset" + secondary variant') ?>

<p class="so-text-muted so-mt-2 so-mb-3">
    <strong>Note:</strong> When <code>href()</code> is set, the button renders as an <code>&lt;a&gt;</code> tag with <code>role="button"</code>.
    The <code>loading()</code> state adds a spinner and can optionally change the button text.
    Icon-only buttons use <code>iconOnly()</code> for proper square styling.
</p>

<h3 class="heading heading-3"><span class="heading-text">FileInput</span></h3>
<?= codeBlock('php', 'UiEngine::file($name)
    ->label($label)
    ->accept($mimeTypes)    // \'image/*\', \'.pdf,.doc\'
    ->multiple()
    ->maxSize($bytes)
    ->maxSizeMB($mb)
    ->images()              // Shortcut for accept(\'image/*\')
    ->documents()           // Shortcut for common document types
    ->preview()             // Show file preview
    ->currentValue($url)    // Show current file for edit
    ->required()
    ->rules($rules)
    ->help($text)') ?>

<h3 class="heading heading-3"><span class="heading-text">Hidden</span></h3>
<?= codeBlock('php', 'UiEngine::hidden($name)
    ->value($value)         // Set hidden input value
    ->id($id)               // Set element ID for JS access
    ->data($key, $value)    // Set data-* attribute
    ->attr($name, $value)   // Set custom HTML attribute
    ->render()              // Render HTML string
    ->renderGroup()         // Same as render() (no wrapper needed)
    ->toArray()             // Export configuration

// Common use cases:
UiEngine::hidden(\'_token\')->value($csrfToken);       // CSRF token
UiEngine::hidden(\'_method\')->value(\'PUT\');          // Method spoofing
UiEngine::hidden(\'id\')->value($record->id);         // Record ID for edits
UiEngine::hidden(\'ref\')->value($_GET[\'ref\'] ?? \'\'); // Tracking data') ?>

<p class="so-text-muted so-mt-2 so-mb-3">
    <strong>Note:</strong> Hidden inputs don't support labels, placeholders, or help text. Always validate hidden field values on the server as users can modify them via browser DevTools.
</p>

<h3 class="heading heading-3"><span class="heading-text">Form</span></h3>
<?= codeBlock('php', 'UiEngine::form($action)
    // HTTP Methods
    ->method($method)       // GET, POST, PUT, PATCH, DELETE
    ->get()                 // GET shortcut
    ->post()                // POST shortcut
    ->put()                 // PUT (adds hidden _method field)
    ->patch()               // PATCH (adds hidden _method field)
    ->delete()              // DELETE (adds hidden _method field)

    // Form Attributes
    ->action($url)          // Set/change form action
    ->id($id)               // Set form ID
    ->enctype($type)        // Encoding type
    ->multipart()           // multipart/form-data for file uploads
    ->target($target)       // Form target (_self, _blank, frame)
    ->newTab()              // Open in new tab (target="_blank")
    ->novalidate()          // Disable browser validation
    ->autocomplete($val)    // Set autocomplete on/off
    ->noAutocomplete()      // Disable autocomplete

    // AJAX & Security
    ->ajax()                // Enable AJAX submission (data-so-ajax)
    ->showLoading($bool)    // Show loading state on submit
    ->csrf($token, $field)  // Add CSRF token hidden field

    // Children
    ->add($element)         // Add form element
    ->addMany($elements)    // Add multiple elements
    ->prepend($element)     // Add at beginning
    ->insertAt($idx, $el)   // Insert at position
    ->remove($element)      // Remove element
    ->clear()               // Remove all children

    // Rendering & Export
    ->render()              // Render form HTML
    ->renderWithValidation() // Render with validation script
    ->exportValidation()    // Export validation rules array
    ->exportValidationScript() // Export as script tag
    ->toArray()             // Export form configuration') ?>

<p class="so-text-muted so-mt-2 so-mb-3">
    <strong>Note:</strong> PUT, PATCH, and DELETE methods automatically add a hidden <code>_method</code> field for method spoofing since HTML forms only support GET and POST.
</p>

<h3 class="heading heading-3"><span class="heading-text">Autocomplete</span></h3>
<?= codeBlock('php', 'UiEngine::autocomplete($name)
    ->label($label)
    ->placeholder($text)
    ->source($url)          // API endpoint for suggestions
    ->sourceData($array)    // Static suggestions array
    ->minLength($n)         // Min chars before search
    ->debounce($ms)         // Debounce delay
    ->required()
    ->rules($rules)') ?>

<h3 class="heading heading-3"><span class="heading-text">ColorInput</span></h3>
<?= codeBlock('php', 'UiEngine::color($name)
    ->label($label)
    ->value($color)         // Hex color value (#RRGGBB)

    // Color formats
    ->format($format)       // hex, rgb, hsl
    ->hex()                 // Set hex format (default)
    ->rgb()                 // Set RGB format
    ->hsl()                 // Set HSL format
    ->alpha()               // Enable alpha/opacity channel

    // Preset colors
    ->presets($colors)      // Array of preset color swatches
    ->addPreset($color)     // Add single preset color
    ->bootstrapPresets()    // Use Bootstrap color palette

    // Text input
    ->showInput()           // Show text input for manual entry (default: true)
    ->hideInput()           // Hide text input (picker only)

    // States
    ->disabled()
    ->readonly()
    ->required()

    // Sizing
    ->size($size)           // sm, md, lg
    ->small()               // Small size
    ->large()               // Large size

    // Validation
    ->rules($rules)
    ->messages($array)      // Custom validation messages

    // Events (from HasEvents trait)
    ->onChange($handler)
    ->onInput($handler)
    ->on($event, $handler)

    // Rendering
    ->render()              // Render input HTML
    ->renderGroup()         // Render with label, help, error
    ->toArray()             // Export configuration') ?>

<p class="so-text-muted so-mt-2 so-mb-3">
    <strong>Note:</strong> The color input renders with <code>data-so-ui-init="color-input"</code> for JS initialization.
    Configuration is passed via <code>data-so-ui-config</code> attribute.
</p>

<h3 class="heading heading-3"><span class="heading-text">DatePicker</span></h3>
<?= codeBlock('php', 'UiEngine::datePicker($name)
    ->label($label)
    ->value($date)
    ->format($format)       // Y-m-d, d/m/Y, etc.
    ->minDate($date)
    ->maxDate($date)
    ->disabledDates($dates)
    ->withTime()            // Include time picker
    ->required()
    ->rules($rules)') ?>

<h3 class="heading heading-3"><span class="heading-text">TimePicker</span></h3>
<?= codeBlock('php', 'UiEngine::timePicker($name)
    ->label($label)
    ->value($time)
    ->format($format)       // H:i, h:i A
    ->step($minutes)        // Minute intervals
    ->required()
    ->rules($rules)') ?>

<h3 class="heading heading-3"><span class="heading-text">Toggle</span></h3>
<?= codeBlock('php', 'UiEngine::toggle($name)
    ->label($label)
    ->onLabel($text)        // Text when on
    ->offLabel($text)       // Text when off
    ->checked($bool)
    ->disabled()') ?>

<h3 class="heading heading-3"><span class="heading-text">Slider</span></h3>
<?= codeBlock('php', 'UiEngine::slider($name)
    ->label($label)
    ->min($n)
    ->max($n)
    ->step($n)
    ->value($value)
    ->showValue()           // Display current value
    ->range()               // Dual-handle range
    ->disabled()') ?>

<h3 class="heading heading-3"><span class="heading-text">Dropzone</span></h3>
<?= codeBlock('php', 'UiEngine::dropzone($name)
    ->label($label)
    ->accept($mimeTypes)
    ->multiple()
    ->maxFiles($n)
    ->maxSize($bytes)
    ->maxSizeMB($mb)
    ->help($text)') ?>

<h3 class="heading heading-3"><span class="heading-text">OtpInput</span></h3>
<?= codeBlock('php', 'UiEngine::otpInput($name)
    // Length
    ->length($n)            // Number of digits (default: 6)
    ->pin4()                // Shortcut for length(4)
    ->pin6()                // Shortcut for length(6)

    // Input Type
    ->inputType($type)      // text, number, password
    ->numeric()             // Numbers only (shows numeric keyboard)
    ->alphanumeric()        // Letters and numbers
    ->masked(bool $val)     // Mask input with dots
    ->password()            // inputType(password) + masked()

    // Behavior
    ->autoSubmit(bool $val) // Auto-submit form when complete
    ->autoFocus(bool $val)  // Auto-focus first input (default: true)
    ->allowPaste(bool $val) // Allow paste from clipboard (default: true)

    // Grouping (visual separators)
    ->groupSize($n)         // Group size for separators
    ->grouped()             // Shortcut for groupSize(3)

    // Variants
    ->variant($variant)     // default, outline, filled, underline
    ->outline()             // Outline style
    ->filled()              // Filled background style
    ->underline()           // Bottom border only style

    // States
    ->required()
    ->disabled()
    ->readonly()

    // Labels & Help
    ->label($label)
    ->help($text)
    ->error($message)

    // Validation
    ->rules($rules)
    ->messages($array)

    // Rendering
    ->render()              // Render OTP input
    ->renderGroup()         // Render with label, help, error
    ->toArray()             // Export configuration

// Events (JavaScript): so:otp:change, so:otp:complete') ?>

<p class="so-text-muted so-mt-2 so-mb-3">
    <strong>Note:</strong> OtpInput renders with <code>data-so-ui-init="otp-input"</code> and individual digit inputs with class <code>so-otp-digit</code>.
    Use <code>grouped()</code> to add visual separators (e.g., XXX-XXX). The hidden input stores the combined value.
</p>

<!-- Display Elements -->
<h2 id="display-elements" class="heading heading-2">
    <span class="mdi mdi-widgets heading-icon"></span>
    <span class="heading-text">Display Elements (22)</span>
</h2>

<h3 class="heading heading-3"><span class="heading-text">Accordion</span></h3>
<?= codeBlock('php', 'UiEngine::accordion($id = null)
    // Items
    ->item($title, $content, $open = false)    // Add accordion item
    ->activeItem($index)                       // Set initially expanded item (0-based)
    ->collapsed()                              // Start with all collapsed

    // Behavior
    ->alwaysOpen($bool = true)                 // Allow multiple panels open simultaneously

    // Styling
    ->flush($bool = true)                      // Remove borders and rounded corners

// PHP & JS Interactivity Methods (JavaScript):
// expand($index), collapse($index), toggle($index)
// expandAll(), collapseAll(), isExpanded($index), getItemCount()
// onShow($callback), onShown($callback), onHide($callback), onHidden($callback)

// Events: so:accordion:show, so:accordion:shown, so:accordion:hide, so:accordion:hidden') ?>

<?= callout('tip', '<strong>Demo:</strong> See <a href="/demo/ui-engine/display/accordion">Accordion Demo</a> for interactive examples with full API reference.') ?>

<h3 class="heading heading-3"><span class="heading-text">Alert</span></h3>
<?= codeBlock('php', 'UiEngine::alert($message = null)
    // Variants
    ->variant($variant)     // primary, secondary, success, danger, warning, info, light, dark
    ->primary() ->secondary() ->success() ->danger()
    ->warning() ->info() ->light() ->dark()

    // Content
    ->message($text)        // Alert message
    ->content($text)        // Alias for message()
    ->title($title)         // Alert heading (wrapped in <strong>)
    ->icon($name)           // Material icon name
    ->footer($html)         // Footer content with <hr> separator

    // Behavior
    ->dismissible($bool = true)    // Add close button
    ->autoDismiss($seconds)        // Auto-dismiss after N seconds

    // Styling
    ->outline($bool = true)        // Border-only style
    ->small($bool = true)          // Compact size

// Shortcuts:
UiEngine::success($message)
UiEngine::error($message)   // Maps to danger variant
UiEngine::warning($message)
UiEngine::info($message)

// PHP & JS Interactivity Methods (JavaScript):
// show(), hide(), close(), dismiss()
// setVariant($variant), setMessage($message), setTitle($title), setIcon($icon)
// toggleOutline($enable), toggleSmall($enable)
// isVisible(), getVariant()
// onClose($callback), onClosed($callback)

// Events: so:alert:close, so:alert:closed') ?>

<?= callout('tip', '<strong>Demo:</strong> See <a href="/demo/ui-engine/display/alert">Alert Demo</a> for interactive examples with full API reference.') ?>

<h3 class="heading heading-3"><span class="heading-text">Badge</span></h3>
<?= codeBlock('php', 'UiEngine::badge($text = null)
    // Variants
    ->variant($variant)
    ->primary() ->secondary() ->success() ->danger()
    ->warning() ->info() ->light() ->dark()

    // Content
    ->text($text)
    ->icon($name)           // Material icon

    // Styles
    ->soft($bool = true)    // Light background variant
    ->pill($bool = true)    // Rounded pill shape

    // Sizing
    ->size($size)           // sm, lg
    ->small()               // size("sm")
    ->large()               // size("lg")

    // Special Types
    ->dot($bool = true)     // Dot indicator (no text)
    ->label($text)          // Label text after dot badge
    ->href($url)            // Make badge clickable

// Interactivity Methods (JavaScript):
// setText($text), getText()
// setVariant($variant), getVariant()
// toggleSoft(), togglePill()
// setSize($size), getSize()
// setIcon($icon)
// isSoft(), isPill()

// Demo: /demo/ui-engine/display/badge.php') ?>

<h3 class="heading heading-3"><span class="heading-text">Card</span></h3>
<?= codeBlock('php', 'UiEngine::card($title)
    ->header($html)
    ->body($content)
    ->footer($html)
    ->image($src, $alt)
    ->imageTop() ->imageBottom()
    ->shadow()
    ->border($color)
    ->background($color)
    ->textColor($color)
    ->noPadding()
    ->clickable()
    ->href($url)
    ->add($element)') ?>

<h3 class="heading heading-3"><span class="heading-text">Modal</span></h3>
<?= codeBlock('php', 'UiEngine::modal($id)
    ->title($title)
    ->body($content)
    ->footer($html)
    ->size($size)           // sm, lg, xl
    ->centered()
    ->scrollable()
    ->static()              // No backdrop click close
    ->addButton($text, $variant, $dismiss)
    ->add($element)') ?>

<h3 class="heading heading-3"><span class="heading-text">Progress</span></h3>
<?= codeBlock('php', 'UiEngine::progress($value)
    ->max($n)               // Default: 100
    ->variant($variant)
    ->striped()
    ->animated()
    ->showLabel()           // Show percentage') ?>

<h3 class="heading heading-3"><span class="heading-text">Table</span></h3>
<?= codeBlock('php', 'UiEngine::table($headers)
    ->rows($data)
    ->columns($config)      // Advanced column config
    ->striped()
    ->bordered()
    ->hover()
    ->small()
    ->darkHeader()
    ->responsive()
    ->sortable()
    ->sortBy($column)
    ->sortDir($direction)
    ->sortUrl($url)') ?>

<h3 class="heading heading-3"><span class="heading-text">Tabs</span></h3>
<?= codeBlock('php', 'UiEngine::tabs()
    ->tab($id, $label, $content, $active)
    ->pills()               // Pill-style tabs
    ->vertical()            // Vertical layout
    ->fill()                // Fill available width
    ->justified()           // Equal width tabs') ?>

<h3 class="heading heading-3"><span class="heading-text">Toast</span></h3>
<?= codeBlock('php', 'UiEngine::toast()
    ->title($title)
    ->message($text)
    ->variant($variant)
    ->duration($ms)         // Auto-hide duration
    ->position($position)   // top-right, top-left, etc.
    ->dismissible()') ?>

<h3 class="heading heading-3"><span class="heading-text">Tooltip</span></h3>
<?= codeBlock('php', 'UiEngine::tooltip($content)
    ->target($selector)
    ->placement($position)  // top, bottom, left, right
    ->trigger($type)        // hover, click, focus') ?>

<h3 class="heading heading-3"><span class="heading-text">Breadcrumb</span></h3>
<?= codeBlock('php', 'UiEngine::breadcrumb()
    ->item($label, $url)
    ->item($label)          // Last item (no link)
    ->separator($char)      // Default: /') ?>

<h3 class="heading heading-3"><span class="heading-text">Pagination</span></h3>
<?= codeBlock('php', 'UiEngine::pagination()
    ->total($count)
    ->perPage($n)
    ->current($page)
    ->url($pattern)         // /users?page={page}
    ->showInfo()            // Showing 1-10 of 100
    ->showFirstLast()
    ->maxLinks($n)
    ->simple()              // Prev/Next only') ?>

<h3 class="heading heading-3"><span class="heading-text">Carousel</span></h3>
<?= codeBlock('php', 'UiEngine::carousel()
    // Slide Management
    ->slides($array)        // Set all slides at once
    ->addSlide($image, $title = null, $description = null, $alt = null)

    // Controls & Indicators
    ->indicators($bool = true)     // Show/hide slide indicators (dots)
    ->controls($bool = true)       // Show/hide prev/next buttons
    ->lineIndicators()             // Use line-style indicators

    // Autoplay Configuration
    ->autoplay($bool = true)       // Enable automatic slide advancement
    ->interval($ms)                // Autoplay interval (default: 5000ms)
    ->pauseOnHover($bool = true)   // Pause on mouse hover

    // Transitions
    ->fade($bool = true)           // Crossfade instead of slide
    ->loop($bool = true)           // Enable wrap-around (default: true)

    // Interaction
    ->touch($bool = true)          // Enable touch/swipe gestures
    ->keyboard($bool = true)       // Enable keyboard navigation

    // Carousel Variants
    ->hero()                       // Center with peek effect
    ->multi($items = null)         // Show multiple slides at once
    ->controlsHover()              // Show controls only on hover

    // Size Variants
    ->small()                      // Small controls/indicators
    ->large()                      // Large controls/indicators

    // Visual Styles
    ->dark($bool = true)           // Dark controls for light backgrounds

/ PHP & JS Interactivity Methods (JavaScript):
// Navigation: next(), prev(), goTo($index)
// Autoplay: play(), pause(), stop()
// State: getCurrentIndex(), getSlideCount(), isPlaying()
// Lifecycle: destroy()
// Static: SOCarousel.getInstance($el), SOCarousel.initAll()

/ Events: so:carousel:slide, so:carousel:slid, so:carousel:play, so:carousel:pause') ?>

<?= callout('tip', '<strong>Demo:</strong> See <a href="/demo/elements/carousel">Carousel Demo</a> for interactive examples with full API reference.') ?>

<h3 class="heading heading-3"><span class="heading-text">Timeline</span></h3>
<?= codeBlock('php', 'UiEngine::timeline()
    ->item($title, $content, $date, $icon)
    ->alternate()           // Alternate left/right
    ->centered()') ?>

<h3 class="heading heading-3"><span class="heading-text">Stepper</span></h3>
<?= codeBlock('php', 'UiEngine::stepper()
    ->step($label, $content, $completed)
    ->current($index)
    ->vertical()
    ->clickable()') ?>

<h3 class="heading heading-3"><span class="heading-text">ListGroup</span></h3>
<?= codeBlock('php', 'UiEngine::listGroup()
    // Content Methods
    ->items($array)                     // Set all items at once
    ->item($content, $options = [])    // Add item with options: [\'icon\', \'url\', \'badge\', \'badgeVariant\', \'variant\', \'active\', \'disabled\']
    ->addItem($content, $badge = null, $variant = null, $active = false, $disabled = false, $url = null, $icon = null, $badgeVariant = null)
    ->updateItem($index, $updates)     // Update item at index with array of changes
    ->removeItem($index)               // Remove item at index
    ->clearItems()                     // Remove all items
    ->getItem($index)                  // Get item at index
    ->getItems()                       // Get all items
    ->getItemCount()                   // Get total item count

    // Styling Methods
    ->flush($bool = true)              // Remove outer borders and rounded corners
    ->numbered($bool = true)           // Numbered list (changes tag to <ol>)
    ->horizontal($val = true)          // Horizontal layout: true, \'sm\', \'md\', \'lg\', \'xl\'
    ->size($size)                      // Size variant: \'sm\' or \'lg\'
    ->small()                          // Small size shortcut
    ->large()                          // Large size shortcut

    // State Methods
    ->setActive($index, $active = true)    // Set active state on item
    ->setDisabled($index, $disabled = true) // Set disabled state on item

    // Rendering
    ->render()                         // Returns HTML string
    ->toArray()                        // Export configuration

// Item Options Format:
$listGroup->item("Item text", [
    \'icon\' => \'check_circle\',      // Material icon name
    \'url\' => \'/path\',              // Makes item a link (<a> tag)
    \'badge\' => \'5\',                 // Badge text/number
    \'badgeVariant\' => \'primary\',    // Badge color: primary, secondary, success, danger, warning, info
    \'variant\' => \'success\',         // Item color: primary, secondary, success, danger, warning, info, light, dark
    \'active\' => true,                // Active state
    \'disabled\' => true,              // Disabled state
]);

// PHP & JS Interactivity Methods (JavaScript):
// Content: updateItem($index, $updates), removeItem($index), clearItems()
// State: setActive($index, $active), setDisabled($index, $disabled), toggleActive($index)
// Getters: getItem($index), getItems(), getItemCount()
// Events: onClick($callback), onItemClick($callback), on($event, $callback)

// Events: so:item:click, so:item:updated, so:item:removed, so:item:toggled, so:items:cleared') ?>

<?= callout('tip', '<strong>Demo:</strong> See <a href="/demo/ui-engine/display/list-group">ListGroup Demo</a> for interactive examples with full API reference.') ?>

<h3 class="heading heading-3"><span class="heading-text">Rating</span></h3>
<?= codeBlock('php', 'UiEngine::rating($name)
    ->value($n)
    ->max($n)               // Default: 5
    ->readonly()
    ->half()                // Allow half stars
    ->icon($name)           // Custom icon') ?>

<h3 class="heading heading-3"><span class="heading-text">Spinner</span></h3>
<?= codeBlock('php', 'UiEngine::spinner()
    ->variant($variant)
    ->size($size)           // sm
    ->text($label)          // Screen reader text
    ->grow()                // Growing animation') ?>

<h3 class="heading heading-3"><span class="heading-text">Skeleton</span></h3>
<?= codeBlock('php', 'UiEngine::skeleton()
    ->type($type)           // text, avatar, card, rect
    ->width($w)
    ->height($h)
    ->lines($n)             // For text type
    ->animation($bool)') ?>

<h3 class="heading heading-3"><span class="heading-text">EmptyState</span></h3>
<?= codeBlock('php', 'UiEngine::emptyState()
    // Content Methods
    ->title($title)             // Set title text (uses <h3> by default)
    ->description($text)        // Set description text
    ->icon($name)               // Material Icons name (e.g., \'inbox\', \'search_off\')
    ->image($url)               // Use image instead of icon
    ->headingLevel($level)      // Set heading level: h3, h4, h5 (default: h3)

    // Actions (Buttons)
    ->addAction($text, $url = null, $variant = \'primary\')  // Add action button
    ->action($text, $url = null, $variant = \'primary\')     // Set single action (replaces all)
    ->actions($array)           // Set multiple actions at once

    // Contextual Variants
    ->variant($variant)         // search, error, success, warning, info, no-permission, danger, forbidden
    ->search()                  // Search results variant
    ->error()                   // Error/danger variant
    ->danger()                  // Alias for error()
    ->success()                 // Success variant
    ->warning()                 // Warning variant
    ->info()                    // Info variant
    ->noPermission()            // No permission / forbidden variant
    ->forbidden()               // Alias for noPermission()

    // Size Variants
    ->size($size)               // sm, lg
    ->small()                   // Small size shortcut
    ->large()                   // Large size shortcut

    // Icon Styling
    ->iconStyle($style)         // circle, gradient
    ->iconCircle()              // Add circular background to icon
    ->iconGradient()            // Add gradient background to icon

    // Layout Variants
    ->compact($bool = true)     // Compact/inline layout (horizontal)
    ->card($bool = true)        // Wrap in card styling with border/padding

    // Inherited methods for styling
    ->id($id)
    ->addClass($class)
    ->attr($name, $value)
    ->data($key, $value)
    ->style($property, $value)

    // Rendering
    ->render()                  // Returns HTML string
    ->toArray()                 // Export configuration

// PHP & JS Interactivity: EmptyState is a display-only component with no runtime interactivity.
// Use action buttons to trigger forms, modals, or navigation.

// CSS Classes:
// .so-empty-state                           Base class
// .so-empty-state-{variant}                 Contextual variants
// .so-empty-state-sm, .so-empty-state-lg    Size variants
// .so-empty-state-compact                   Inline layout
// .so-empty-state-card                      Card styling
// .so-empty-state-icon                      Icon wrapper
// .so-empty-state-icon-circle               Circle icon background
// .so-empty-state-icon-gradient             Gradient icon background
// .so-empty-state-title                     Title text
// .so-empty-state-text                      Description text
// .so-empty-state-actions                   Action buttons wrapper
// .so-empty-state-image                     Image element') ?>

<?= callout('tip', '<strong>Demo:</strong> See <a href="/demo/elements/empty-states">Empty State Demo</a> for interactive examples with full API reference.') ?>

<h3 class="heading heading-3"><span class="heading-text">MediaObject</span></h3>
<?= codeBlock('php', 'UiEngine::mediaObject()
    // Media Methods
    ->image($url, $alt = \'\')         // Set image media with alt text
    ->icon($icon, $variant = null)  // Set icon media: primary, success, warning, danger, info, secondary
    ->mediaSize($size)              // Set media size (CSS value: \'64px\', \'4rem\')
    ->iconVariant($variant)         // Set icon color variant

    // Content Methods
    ->title($title)                 // Set title/heading text
    ->content($content)             // Set body content text
    ->body($body)                   // Alias for content()

    // Position Methods
    ->mediaPosition($position)      // \'start\' (left) or \'end\' (right)
    ->mediaStart()                  // Media on left (default)
    ->mediaEnd()                    // Media on right
    ->reverse()                     // Alias for mediaEnd()

    // Alignment Methods
    ->align($align)                 // \'top\', \'middle\', \'bottom\'
    ->alignTop()                    // Top alignment (default)
    ->alignMiddle()                 // Middle/center alignment
    ->alignCenter()                 // Alias for alignMiddle()
    ->alignBottom()                 // Bottom alignment

    // Getters
    ->getMedia()                    // Get media source
    ->getMediaType()                // Get media type (image/icon)
    ->getTitle()                    // Get title
    ->getContent()                  // Get content
    ->getMediaPosition()            // Get position
    ->getAlign()                    // Get alignment

    // Rendering
    ->render()                      // Returns HTML string
    ->toArray()                     // Export configuration

// Common Patterns:

// Image with content
$media = UiEngine::mediaObject()
    ->image(\'avatar.jpg\', \'User Name\')
    ->title(\'John Doe\')
    ->content(\'Senior Developer\')
    ->alignMiddle();

// Icon notification
$notification = UiEngine::mediaObject()
    ->icon(\'notifications\', \'primary\')
    ->mediaSize(\'48px\')
    ->title(\'New Message\')
    ->content(\'You have received a new message.\');

// Media on right
$feature = UiEngine::mediaObject()
    ->image(\'feature.jpg\')
    ->title(\'Feature Title\')
    ->content(\'Feature description...\')
    ->mediaEnd()
    ->alignMiddle();

// PHP & JS Interactivity Methods (JavaScript):
// Dynamic Updates: setMedia($media, $type), setTitle($title), setContent($content)
// Position: togglePosition()
// Getters: getMedia(), getMediaType(), getTitle(), getContent(), getMediaPosition(), getAlign()
// Events: onMediaChange($callback), onTitleChange($callback), onContentChange($callback), onPositionChange($callback)

// Events: so:media:mediaChanged, so:media:titleChanged, so:media:contentChanged, so:media:positionChanged,
//         so:media:sizeChanged, so:media:variantChanged, so:media:alignChanged, so:media:positionToggled') ?>

<?= callout('tip', '<strong>Demo:</strong> See <a href="/demo/ui-engine/display/media-object">MediaObject Demo</a> for interactive examples with full API reference.') ?>

<h3 class="heading heading-3"><span class="heading-text">Modal</span></h3>
<?= codeBlock('php', 'UiEngine::modal($id)
    // Content Methods
    ->title($title)                     // Set modal title
    ->addButton($text, $variant, $dismiss, $attributes)  // Add footer button
    ->closeButton($text = \'Close\')     // Add close/cancel button
    ->saveButton($text = \'Save\', $variant = \'primary\')  // Add save/submit button

    // Size Methods
    ->size($size)                       // Set size: sm, md, lg, xl, fullscreen
    ->small()                           // Small modal (380px)
    ->large()                           // Large modal (720px)
    ->extraLarge()                      // Extra large modal (960px)
    ->fullscreen()                      // Fullscreen modal

    // Behavior Methods
    ->scrollable($scrollable = true)    // Make modal body scrollable
    ->centered($centered = true)        // Center modal vertically
    ->staticBackdrop($static = true)    // Prevent close on backdrop click
    ->hideClose()                       // Hide X close button
    ->noKeyboard()                      // Disable Escape key close
    ->noFocus()                         // Disable auto-focus

    // Getters
    ->getTitle()                        // Get modal title
    ->getButtons()                      // Get footer buttons array
    ->getSize()                         // Get modal size
    ->isScrollable()                    // Check if scrollable
    ->isCentered()                      // Check if centered
    ->hasStaticBackdrop()               // Check if static backdrop
    ->isVisible()                       // Check if modal is visible

// JavaScript
modal.show()                            // Show the modal
modal.hide()                            // Hide the modal
modal.toggle()                          // Toggle modal visibility
modal.dispose()                         // Cleanup and remove modal
modal.setTitle(title)                   // Update title dynamically
modal.setBody(content)                  // Update body content dynamically
modal.addButtonDynamic(text, variant, dismiss, attrs)  // Add button dynamically
modal.clearButtons()                    // Remove all footer buttons

// Events: onShow($callback), onShown($callback), onHide($callback), onHidden($callback), onDismiss($callback)

// Events: so:modal:show, so:modal:shown, so:modal:hide, so:modal:hidden, so:modal:dismiss,
//         so:modal:sizeChanged, so:modal:scrollableChanged, so:modal:centeredChanged,
//         so:modal:staticBackdropChanged, so:modal:closeButtonChanged, so:modal:keyboardChanged,
//         so:modal:focusChanged, so:modal:titleChanged, so:modal:bodyChanged, so:modal:buttonAdded,
//         so:modal:buttonsCleared, so:modal:disposed') ?>

<?= callout('tip', '<strong>Demo:</strong> See <a href="/demo/ui-engine/display/modal">Modal Demo</a> for interactive examples with full API reference.') ?>

<h3 class="heading heading-3"><span class="heading-text">CodeBlock</span></h3>
<?= codeBlock('php', 'UiEngine::codeBlock($code)
    ->language($lang)       // php, javascript, html, css, json, sql, bash
    ->lineNumbers()
    ->highlightLines($lines)
    ->copyButton()
    ->title($title)') ?>

<!-- Navigation Elements -->
<h2 id="navigation-elements" class="heading heading-2">
    <span class="mdi mdi-menu heading-icon"></span>
    <span class="heading-text">Navigation Elements (4)</span>
</h2>

<h3 class="heading heading-3"><span class="heading-text">Dropdown</span></h3>
<?= codeBlock('php', 'UiEngine::dropdown()
    ->trigger($button)
    ->item($label, $url, $icon)
    ->header($text)
    ->divider()
    ->direction($dir)       // down, up, start, end') ?>

<h3 class="heading heading-3"><span class="heading-text">ContextMenu</span></h3>
<?= codeBlock('php', 'UiEngine::contextMenu($targetSelector)
    ->item($label, $action, $icon)
    ->submenu($label, $items)
    ->divider()') ?>

<h3 class="heading heading-3"><span class="heading-text">Navbar</span></h3>
<?= codeBlock('php', 'UiEngine::navbar()
    ->brand($text, $url, $image)
    ->item($label, $url, $active)
    ->dropdown($label, $items)
    ->right($content)
    ->sticky()
    ->dark()
    ->expand($breakpoint)') ?>

<h3 class="heading heading-3"><span class="heading-text">Collapse</span></h3>
<?= codeBlock('php', 'UiEngine::collapse($id)
    ->toggle($element)
    ->content($html)
    ->show()                // Start expanded
    ->horizontal()') ?>

<!-- Layout Elements -->
<h2 id="layout-elements" class="heading heading-2">
    <span class="mdi mdi-view-grid heading-icon"></span>
    <span class="heading-text">Layout Elements (6)</span>
</h2>

<h3 class="heading heading-3"><span class="heading-text">Container</span></h3>
<?= codeBlock('php', 'UiEngine::container()
    ->fluid()               // Full width
    ->add($element)') ?>

<h3 class="heading heading-3"><span class="heading-text">Row</span></h3>
<?= codeBlock('php', 'UiEngine::row()
    ->gutters($size)        // g-0 to g-5
    ->guttersX($size)
    ->guttersY($size)
    ->align($position)      // start, center, end
    ->justify($position)    // start, center, end, between, around, evenly
    ->add($column)') ?>

<h3 class="heading heading-3"><span class="heading-text">Column</span></h3>
<?= codeBlock('php', 'UiEngine::col($size)           // 1-12
    ->xs($n) ->sm($n) ->md($n) ->lg($n) ->xl($n) ->xxl($n)
    ->offset($n)
    ->offsetMd($n)          // etc.
    ->order($n)
    ->add($element)') ?>

<h3 class="heading heading-3"><span class="heading-text">Divider</span></h3>
<?= codeBlock('php', 'UiEngine::divider()
    ->text($label)          // Centered text
    ->vertical()') ?>

<h3 class="heading heading-3"><span class="heading-text">Grid</span></h3>
<?= codeBlock('php', 'UiEngine::grid()
    ->cols($n)
    ->colsSm($n) ->colsMd($n) ->colsLg($n)
    ->gap($size)
    ->template($template)   // CSS grid-template-columns
    ->rows($template)
    ->areas($array)
    ->add($element)') ?>

<h3 class="heading heading-3"><span class="heading-text">Flex</span></h3>
<?= codeBlock('php', 'UiEngine::flex()
    ->direction($dir)       // row, column, row-reverse, column-reverse
    ->justify($pos)         // start, center, end, between, around, evenly
    ->align($pos)           // start, center, end, baseline, stretch
    ->wrap() ->nowrap()
    ->gap($size)
    ->add($element)') ?>

<!-- Common Methods -->
<h2 id="common-methods" class="heading heading-2">
    <span class="mdi mdi-function heading-icon"></span>
    <span class="heading-text">Common Methods</span>
</h2>

<p>All elements inherit these common methods:</p>

<?= codeBlock('php', '// Identification
->id($id)
->name($name)

// Classes & Styles
->addClass($class)
->removeClass($class)
->style($css)

// Attributes
->attr($name, $value)
->data($name, $value)       // data-* attributes

// Rendering
->render()                  // Returns HTML string
->toHtml()                  // Alias for render()
->toConfig()                // Export as config array

// Adding children
->add($element)
->add($html)

// From config
UiEngine::fromConfig($array)
UiEngine::fromJson($json)') ?>

<?= callout('info', '
    <strong>See Also:</strong>
    <ul class="so-mb-0">
        <li><a href="/docs/dev-ui-engine">UiEngine Developer Guide</a></li>
        <li><a href="/docs/dev-ui-engine-forms">Forms Guide</a></li>
        <li><a href="/docs/dev-ui-engine-layouts">Layouts Guide</a></li>
        <li><a href="/docs/dev-ui-engine-advanced">Advanced Patterns</a></li>
    </ul>
') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
