<?php
/**
 * UiEngine System Overview
 *
 * General documentation for UiEngine - programmatic UI generation.
 */

$pageTitle = 'UiEngine System';
$pageIcon = 'view-dashboard';
$toc = [
    ['id' => 'overview', 'title' => 'Overview', 'level' => 2],
    ['id' => 'architecture', 'title' => 'Architecture', 'level' => 2],
    ['id' => 'element-categories', 'title' => 'Element Categories', 'level' => 2],
    ['id' => 'form-elements', 'title' => 'Form Elements (17)', 'level' => 3],
    ['id' => 'display-elements', 'title' => 'Display Elements (23)', 'level' => 3],
    ['id' => 'navigation-elements', 'title' => 'Navigation Elements (4)', 'level' => 3],
    ['id' => 'layout-elements', 'title' => 'Layout Elements (6)', 'level' => 3],
    ['id' => 'usage-patterns', 'title' => 'Usage Patterns', 'level' => 2],
    ['id' => 'fluent-api', 'title' => 'Fluent API', 'level' => 3],
    ['id' => 'config-arrays', 'title' => 'Config Arrays', 'level' => 3],
    ['id' => 'symmetric-api', 'title' => 'Symmetric PHP/JS API', 'level' => 2],
    ['id' => 'validation-integration', 'title' => 'Validation Integration', 'level' => 2],
];
$breadcrumbs = [['label' => 'UiEngine System']];
$lastUpdated = '2026-02-03';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="ui-engine" class="heading heading-1">
    <span class="mdi mdi-view-dashboard heading-icon"></span>
    <span class="heading-text">UiEngine System</span>
</h1>

<p class="text-lead">
    Programmatic UI generation with symmetric PHP/JS API. Build forms, layouts, and complete interfaces with 49 pre-built elements.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-new">New</span>
    <span class="badge badge-production">Production</span>
    <span class="badge badge-unique">Unique</span>
</div>

<!-- Overview -->
<h2 id="overview" class="heading heading-2">
    <span class="mdi mdi-information heading-icon"></span>
    <span class="heading-text">Overview</span>
</h2>

<p>
    UiEngine is a comprehensive UI generation system that allows you to build user interfaces programmatically in both PHP (server-side) and JavaScript (client-side). It provides a consistent, fluent API across both languages, ensuring seamless development experience whether you're rendering on the server or dynamically building UI in the browser.
</p>

<?= callout('info', '
    <strong>Key Benefits:</strong>
    <ul class="so-mb-0">
        <li><strong>Symmetric API</strong> - Same method names and patterns in PHP and JavaScript</li>
        <li><strong>49 Pre-built Elements</strong> - Forms, display components, navigation, and layouts</li>
        <li><strong>Validation Integration</strong> - Server-side rules automatically export to client-side validation</li>
        <li><strong>Fluent &amp; Config APIs</strong> - Choose your preferred coding style</li>
        <li><strong>Extensible</strong> - Register custom elements for project-specific needs</li>
    </ul>
') ?>

<!-- Architecture -->
<h2 id="architecture" class="heading heading-2">
    <span class="mdi mdi-cube-outline heading-icon"></span>
    <span class="heading-text">Architecture</span>
</h2>

<h3 class="heading heading-3">
    <span class="heading-text">PHP (Server-Side)</span>
</h3>

<?= codeBlock('text', 'Core/UiEngine/
├── UiEngine.php              # Main factory class
├── ElementFactory.php        # Element registration & creation
├── Elements/
│   ├── Element.php           # Base element class
│   ├── FormElement.php       # Base form element
│   ├── Form/                 # Form elements (17)
│   ├── Display/              # Display elements (22)
│   ├── Navigation/           # Navigation elements (4)
│   └── Layout/               # Layout elements (6)
└── Traits/
    ├── HasAttributes.php     # HTML attributes
    ├── HasValidation.php     # Validation rules
    └── HasChildren.php       # Child elements') ?>

<h3 class="heading heading-3">
    <span class="heading-text">JavaScript (Client-Side)</span>
</h3>

<?= codeBlock('text', 'js/ui-engine/
├── core/
│   ├── UiEngine.js           # Main factory & registry
│   ├── Element.js            # Base element class
│   └── FormElement.js        # Base form element
├── elements/
│   ├── form/                 # Form elements (17)
│   ├── display/              # Display elements (22)
│   ├── navigation/           # Navigation elements (4)
│   └── layout/               # Layout elements (6)
└── index.js                  # Auto-initialization') ?>

<!-- Element Categories -->
<h2 id="element-categories" class="heading heading-2">
    <span class="mdi mdi-format-list-bulleted-type heading-icon"></span>
    <span class="heading-text">Element Categories</span>
</h2>

<p>
    UiEngine provides <strong>49 elements</strong> organized into 4 categories:
</p>

<!-- Form Elements -->
<h3 id="form-elements" class="heading heading-3">
    <span class="mdi mdi-form-textbox heading-icon"></span>
    <span class="heading-text">Form Elements (17)</span>
</h3>

<?= table([
    ['Element', 'Description', 'Common Methods'],
    ['<code>Input</code>', 'Text input with types (text, email, number, etc.)', '<code>type()</code>, <code>placeholder()</code>, <code>maxlength()</code>'],
    ['<code>Select</code>', 'Dropdown select with single/multiple selection', '<code>options()</code>, <code>multiple()</code>, <code>searchable()</code>'],
    ['<code>Checkbox</code>', 'Checkbox with optional switch mode', '<code>checked()</code>, <code>switch()</code>, <code>inline()</code>'],
    ['<code>Radio</code>', 'Radio button groups', '<code>options()</code>, <code>inline()</code>, <code>checked()</code>'],
    ['<code>Textarea</code>', 'Multi-line text input', '<code>rows()</code>, <code>maxlength()</code>, <code>showCounter()</code>'],
    ['<code>Button</code>', 'Action buttons with variants', '<code>variant()</code>, <code>icon()</code>, <code>loading()</code>'],
    ['<code>FileInput</code>', 'File upload with preview', '<code>accept()</code>, <code>multiple()</code>, <code>preview()</code>'],
    ['<code>Hidden</code>', 'Hidden form field', '<code>value()</code>'],
    ['<code>Form</code>', 'Form wrapper with CSRF', '<code>action()</code>, <code>method()</code>, <code>ajax()</code>'],
    ['<code>Autocomplete</code>', 'Search input with suggestions', '<code>source()</code>, <code>minLength()</code>, <code>debounce()</code>'],
    ['<code>ColorInput</code>', 'Color picker input', '<code>format()</code>, <code>swatches()</code>'],
    ['<code>DatePicker</code>', 'Date selection', '<code>format()</code>, <code>minDate()</code>, <code>maxDate()</code>'],
    ['<code>TimePicker</code>', 'Time selection', '<code>format()</code>, <code>step()</code>'],
    ['<code>Toggle</code>', 'Toggle switch', '<code>onLabel()</code>, <code>offLabel()</code>'],
    ['<code>Slider</code>', 'Range slider input', '<code>min()</code>, <code>max()</code>, <code>step()</code>'],
    ['<code>Dropzone</code>', 'Drag & drop file upload', '<code>maxFiles()</code>, <code>maxSize()</code>'],
    ['<code>OtpInput</code>', 'One-time password input', '<code>length()</code>, <code>numeric()</code>'],
]) ?>

<!-- Display Elements -->
<h3 id="display-elements" class="heading heading-3">
    <span class="mdi mdi-widgets heading-icon"></span>
    <span class="heading-text">Display Elements (23)</span>
</h3>

<?= table([
    ['Element', 'Description', 'Common Methods'],
    ['<code>Accordion</code>', 'Collapsible content panels', '<code>item()</code>, <code>alwaysOpen()</code>'],
    ['<code>Alert</code>', 'Dismissible alert messages', '<code>variant()</code>, <code>dismissible()</code>, <code>icon()</code>'],
    ['<code>Badge</code>', 'Status badges & labels', '<code>variant()</code>, <code>soft()</code>, <code>pill()</code>, <code>icon()</code>, <code>dot()</code>'],
    ['<code>Card</code>', 'Content cards with header/footer', '<code>header()</code>, <code>footer()</code>, <code>image()</code>'],
    ['<code>Modal</code>', 'Modal dialogs', '<code>title()</code>, <code>size()</code>, <code>footer()</code>'],
    ['<code>Progress</code>', 'Progress bars', '<code>value()</code>, <code>variant()</code>, <code>striped()</code>'],
    ['<code>Table</code>', 'Data tables', '<code>columns()</code>, <code>rows()</code>, <code>sortable()</code>'],
    ['<code>Tabs</code>', 'Tabbed content', '<code>tab()</code>, <code>vertical()</code>, <code>pills()</code>'],
    ['<code>Toast</code>', 'Toast notifications', '<code>message()</code>, <code>variant()</code>, <code>duration()</code>'],
    ['<code>Tooltip</code>', 'Hover tooltips', '<code>content()</code>, <code>placement()</code>'],
    ['<code>Breadcrumb</code>', 'Navigation breadcrumbs', '<code>item()</code>, <code>separator()</code>'],
    ['<code>Pagination</code>', 'Page navigation', '<code>total()</code>, <code>perPage()</code>, <code>current()</code>'],
    ['<code>Carousel</code>', 'Image/content carousel', '<code>slide()</code>, <code>autoplay()</code>'],
    ['<code>Timeline</code>', 'Vertical timeline', '<code>item()</code>, <code>alternate()</code>'],
    ['<code>Stepper</code>', 'Step wizard', '<code>step()</code>, <code>vertical()</code>'],
    ['<code>ListGroup</code>', 'Flexible list component with badges, icons, and actions', '<code>item()</code>, <code>addItem()</code>, <code>flush()</code>, <code>numbered()</code>, <code>horizontal()</code>'],
    ['<code>Rating</code>', 'Star rating', '<code>value()</code>, <code>max()</code>, <code>readonly()</code>'],
    ['<code>Spinner</code>', 'Loading spinner', '<code>variant()</code>, <code>size()</code>'],
    ['<code>Skeleton</code>', 'Loading skeleton', '<code>type()</code>, <code>width()</code>, <code>lines()</code>'],
    ['<code>EmptyState</code>', 'Empty content placeholder', '<code>icon()</code>, <code>title()</code>, <code>action()</code>'],
    ['<code>MediaObject</code>', 'Media (image/icon) with text content layout', '<code>image()</code>, <code>icon()</code>, <code>title()</code>, <code>content()</code>, <code>mediaPosition()</code>, <code>align()</code>'],
    ['<code>Modal</code>', 'Dialog overlay for focused interactions', '<code>title()</code>, <code>size()</code>, <code>scrollable()</code>, <code>centered()</code>, <code>show()</code>, <code>hide()</code>'],
    ['<code>CodeBlock</code>', 'Syntax highlighted code', '<code>language()</code>, <code>lineNumbers()</code>'],
]) ?>

<!-- Navigation Elements -->
<h3 id="navigation-elements" class="heading heading-3">
    <span class="mdi mdi-menu heading-icon"></span>
    <span class="heading-text">Navigation Elements (4)</span>
</h3>

<?= table([
    ['Element', 'Description', 'Common Methods'],
    ['<code>Dropdown</code>', 'Dropdown menus', '<code>trigger()</code>, <code>item()</code>, <code>divider()</code>'],
    ['<code>ContextMenu</code>', 'Right-click context menus', '<code>item()</code>, <code>submenu()</code>'],
    ['<code>Navbar</code>', 'Navigation bar', '<code>brand()</code>, <code>item()</code>, <code>sticky()</code>'],
    ['<code>Collapse</code>', 'Collapsible content', '<code>toggle()</code>, <code>show()</code>'],
]) ?>

<!-- Layout Elements -->
<h3 id="layout-elements" class="heading heading-3">
    <span class="mdi mdi-view-grid heading-icon"></span>
    <span class="heading-text">Layout Elements (6)</span>
</h3>

<?= table([
    ['Element', 'Description', 'Common Methods'],
    ['<code>Container</code>', 'Content container', '<code>fluid()</code>'],
    ['<code>Row</code>', 'Grid row', '<code>gutters()</code>, <code>align()</code>, <code>justify()</code>'],
    ['<code>Column</code>', 'Grid column', '<code>xs()</code>, <code>sm()</code>, <code>md()</code>, <code>lg()</code>, <code>xl()</code>'],
    ['<code>Divider</code>', 'Horizontal divider', '<code>text()</code>, <code>vertical()</code>'],
    ['<code>Grid</code>', 'CSS Grid layout', '<code>cols()</code>, <code>gap()</code>'],
    ['<code>Flex</code>', 'Flexbox container', '<code>direction()</code>, <code>wrap()</code>, <code>justify()</code>'],
]) ?>

<!-- Usage Patterns -->
<h2 id="usage-patterns" class="heading heading-2">
    <span class="mdi mdi-code-braces heading-icon"></span>
    <span class="heading-text">Usage Patterns</span>
</h2>

<p>
    UiEngine supports two complementary usage patterns. Choose the one that fits your workflow best.
</p>

<!-- Fluent API -->
<h3 id="fluent-api" class="heading heading-3">
    <span class="heading-text">Fluent API (Method Chaining)</span>
</h3>

<p>
    The fluent API allows method chaining for readable, sequential configuration:
</p>

<?= codeTabs('fluent-example', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

$input = UiEngine::input(\'email\')
    ->label(\'Email Address\')
    ->placeholder(\'you@example.com\')
    ->required()
    ->rules(\'required|email\')
    ->help(\'We\\\'ll never share your email.\');

echo $input->renderGroup();'
    ],
    [
        'label' => 'JavaScript',
        'language' => 'javascript',
        'code' => 'const input = UiEngine.input(\'email\')
    .label(\'Email Address\')
    .placeholder(\'you@example.com\')
    .required()
    .rules(\'required|email\')
    .help(\'We\\\'ll never share your email.\');

document.body.innerHTML = input.toHtml();'
    ],
]) ?>

<!-- Config Arrays -->
<h3 id="config-arrays" class="heading heading-3">
    <span class="heading-text">Config Arrays (Declarative)</span>
</h3>

<p>
    The config array approach is ideal for dynamic forms, stored configurations, or JSON-based UI definitions:
</p>

<?= codeTabs('config-example', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

$config = [
    \'type\' => \'input\',
    \'name\' => \'email\',
    \'label\' => \'Email Address\',
    \'placeholder\' => \'you@example.com\',
    \'required\' => true,
    \'rules\' => \'required|email\',
    \'help\' => \'We\\\'ll never share your email.\',
];

$input = UiEngine::fromConfig($config);
echo $input->renderGroup();'
    ],
    [
        'label' => 'JavaScript',
        'language' => 'javascript',
        'code' => 'const config = {
    type: \'input\',
    name: \'email\',
    label: \'Email Address\',
    placeholder: \'you@example.com\',
    required: true,
    rules: \'required|email\',
    help: \'We\\\'ll never share your email.\',
};

const input = UiEngine.fromConfig(config);
document.body.innerHTML = input.toHtml();'
    ],
]) ?>

<?= callout('tip', '
    <strong>Converting Between Patterns:</strong> Use <code>toConfig()</code> to export any element\'s current state as a config array. This is useful for storing form definitions in databases or sharing configurations.
') ?>

<!-- Symmetric API -->
<h2 id="symmetric-api" class="heading heading-2">
    <span class="mdi mdi-swap-horizontal heading-icon"></span>
    <span class="heading-text">Symmetric PHP/JS API</span>
</h2>

<p>
    UiEngine maintains API symmetry between PHP and JavaScript. The same method names, parameters, and behaviors work identically in both languages:
</p>

<?= codeTabs('symmetric-example', [
    [
        'label' => 'PHP',
        'language' => 'php',
        'code' => '// Building a form in PHP (server-side rendering)
$form = UiEngine::form(\'/login\')
    ->method(\'POST\')
    ->add(
        UiEngine::email(\'email\')
            ->label(\'Email\')
            ->required()
    )
    ->add(
        UiEngine::password(\'password\')
            ->label(\'Password\')
            ->required()
    )
    ->add(
        UiEngine::submit(\'Sign In\')
    );

echo $form->render();'
    ],
    [
        'label' => 'JavaScript',
        'language' => 'javascript',
        'code' => '// Building the same form in JavaScript (client-side rendering)
const form = UiEngine.form(\'/login\')
    .method(\'POST\')
    .add(
        UiEngine.email(\'email\')
            .label(\'Email\')
            .required()
    )
    .add(
        UiEngine.password(\'password\')
            .label(\'Password\')
            .required()
    )
    .add(
        UiEngine.submit(\'Sign In\')
    );

document.getElementById(\'app\').innerHTML = form.toHtml();'
    ],
]) ?>

<p>
    This symmetry enables several powerful patterns:
</p>

<ul>
    <li><strong>Server-side rendering</strong> with PHP for initial page loads</li>
    <li><strong>Client-side rendering</strong> with JavaScript for dynamic UIs</li>
    <li><strong>Hybrid rendering</strong> - initial render in PHP, updates in JavaScript</li>
    <li><strong>Shared configurations</strong> - define once, render anywhere</li>
</ul>

<!-- Validation Integration -->
<h2 id="validation-integration" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Validation Integration</span>
</h2>

<p>
    UiEngine integrates seamlessly with the framework's validation system. Define validation rules once in PHP, and they automatically export to JavaScript for client-side validation.
</p>

<?= codeBlock('php', '<?php
// Define rules on form elements
$form = UiEngine::form(\'/register\')
    ->add(
        UiEngine::input(\'username\')
            ->label(\'Username\')
            ->rules(\'required|min:3|max:20|alpha_dash|unique:users,username\')
    )
    ->add(
        UiEngine::email(\'email\')
            ->label(\'Email\')
            ->rules(\'required|email|unique:users,email\')
    )
    ->add(
        UiEngine::password(\'password\')
            ->label(\'Password\')
            ->rules(\'required|min:8\')
    );

// Render form
echo $form->render();

// Export validation rules to JavaScript
echo $form->exportValidationScript();') ?>

<p>
    The exported script enables real-time client-side validation that matches server-side rules:
</p>

<ul>
    <li><strong>Same rules</strong> - PHP validation rules work identically in JavaScript</li>
    <li><strong>Real-time feedback</strong> - Errors show as users type</li>
    <li><strong>Server-side fallback</strong> - Always validate on server for security</li>
    <li><strong>Custom messages</strong> - Define per-field error messages</li>
</ul>

<?= callout('warning', '
    <strong>Security Note:</strong> Client-side validation improves user experience but should never replace server-side validation. Always validate on the server as client-side checks can be bypassed.
') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Learn More</span>
</h3>

<p>
    For detailed implementation guides and examples, see the developer documentation:
</p>

<ul>
    <li><a href="/docs/dev-ui-engine">UiEngine Developer Guide</a> - Getting started and basics</li>
    <li><a href="/docs/dev-ui-engine-forms">Forms Guide</a> - Building forms step-by-step</li>
    <li><a href="/docs/dev-ui-engine-layouts">Layouts Guide</a> - Building layouts and pages</li>
    <li><a href="/docs/dev-ui-engine-tables">Tables Guide</a> - Data tables and lists</li>
    <li><a href="/docs/dev-ui-engine-elements">Element Reference</a> - Complete API for all 49 elements</li>
    <li><a href="/docs/dev-ui-engine-advanced">Advanced Patterns</a> - Custom elements, AJAX, and dynamic forms</li>
</ul>

<?php include __DIR__ . '/../_layout-end.php'; ?>
