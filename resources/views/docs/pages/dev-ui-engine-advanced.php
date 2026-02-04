<?php
/**
 * UiEngine Advanced Patterns
 *
 * Advanced usage patterns: custom elements, AJAX, dynamic forms, JS integration.
 */

$pageTitle = 'UiEngine Advanced Patterns';
$pageIcon = 'code-tags-check';
$toc = [
    ['id' => 'custom-elements', 'title' => 'Custom Elements', 'level' => 2],
    ['id' => 'ajax-forms', 'title' => 'AJAX Forms', 'level' => 2],
    ['id' => 'dynamic-forms', 'title' => 'Dynamic Forms', 'level' => 2],
    ['id' => 'js-integration', 'title' => 'JavaScript Integration', 'level' => 2],
    ['id' => 'server-side-rendering', 'title' => 'Server-Side Rendering', 'level' => 2],
    ['id' => 'form-builders', 'title' => 'Form Builders', 'level' => 2],
    ['id' => 'best-practices', 'title' => 'Best Practices', 'level' => 2],
];
$breadcrumbs = [['label' => 'Development', 'url' => '/docs#dev-panel'], ['label' => 'UiEngine Advanced Patterns']];
$lastUpdated = '2026-02-03';

include __DIR__ . '/../_layout.php';
?>

<!-- Header -->
<h1 id="dev-ui-engine-advanced" class="heading heading-1">
    <span class="mdi mdi-code-tags-check heading-icon"></span>
    <span class="heading-text">UiEngine Advanced Patterns</span>
</h1>

<p class="text-lead">
    Advanced usage patterns for UiEngine including custom elements, AJAX forms, dynamic form generation, JavaScript integration, and server-side rendering strategies.
</p>

<div class="flex gap-2 mb-4">
    <span class="badge badge-guide">Guide</span>
    <span class="badge badge-new">New</span>
    <span class="badge badge-advanced">Advanced</span>
</div>

<!-- Custom Elements -->
<h2 id="custom-elements" class="heading heading-2">
    <span class="mdi mdi-puzzle-outline heading-icon"></span>
    <span class="heading-text">Custom Elements</span>
</h2>

<p>
    Create custom element types for project-specific UI components.
</p>

<h3 class="heading heading-3">
    <span class="heading-text">Creating a Custom Element (PHP)</span>
</h3>

<?= codeBlock('php', '<?php
namespace App\UiEngine\Elements;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Traits\HasValidation;

class DateRangePicker extends FormElement
{
    use HasValidation;

    protected string $type = \'daterange\';
    protected string $tagName = \'div\';

    protected ?string $startDate = null;
    protected ?string $endDate = null;
    protected string $format = \'Y-m-d\';
    protected ?string $minDate = null;
    protected ?string $maxDate = null;

    public function startDate(?string $date): static
    {
        $this->startDate = $date;
        return $this;
    }

    public function endDate(?string $date): static
    {
        $this->endDate = $date;
        return $this;
    }

    public function format(string $format): static
    {
        $this->format = $format;
        return $this;
    }

    public function minDate(?string $date): static
    {
        $this->minDate = $date;
        return $this;
    }

    public function maxDate(?string $date): static
    {
        $this->maxDate = $date;
        return $this;
    }

    public function render(): string
    {
        $startName = $this->name . \'_start\';
        $endName = $this->name . \'_end\';

        return \'
        <div class="so-daterange-picker\' . ($this->classes ? \' \' . implode(\' \', $this->classes) : \'\') . \'">
            <div class="so-daterange-input">
                <input type="date"
                       class="so-form-control"
                       name="\' . e($startName) . \'"
                       value="\' . e($this->startDate) . \'"
                       \' . ($this->minDate ? \'min="\' . e($this->minDate) . \'"\' : \'\') . \'
                       \' . ($this->maxDate ? \'max="\' . e($this->maxDate) . \'"\' : \'\') . \'
                       \' . ($this->required ? \'required\' : \'\') . \'>
            </div>
            <span class="so-daterange-separator">to</span>
            <div class="so-daterange-input">
                <input type="date"
                       class="so-form-control"
                       name="\' . e($endName) . \'"
                       value="\' . e($this->endDate) . \'"
                       \' . ($this->minDate ? \'min="\' . e($this->minDate) . \'"\' : \'\') . \'
                       \' . ($this->maxDate ? \'max="\' . e($this->maxDate) . \'"\' : \'\') . \'
                       \' . ($this->required ? \'required\' : \'\') . \'>
            </div>
        </div>\';
    }

    public function toConfig(): array
    {
        return array_merge(parent::toConfig(), [
            \'startDate\' => $this->startDate,
            \'endDate\' => $this->endDate,
            \'format\' => $this->format,
            \'minDate\' => $this->minDate,
            \'maxDate\' => $this->maxDate,
        ]);
    }

    protected function initFromConfig(array $config): void
    {
        parent::initFromConfig($config);
        $this->startDate = $config[\'startDate\'] ?? null;
        $this->endDate = $config[\'endDate\'] ?? null;
        $this->format = $config[\'format\'] ?? \'Y-m-d\';
        $this->minDate = $config[\'minDate\'] ?? null;
        $this->maxDate = $config[\'maxDate\'] ?? null;
    }
}') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Registering Custom Elements</span>
</h3>

<?= codeBlock('php', '<?php
// In a service provider or bootstrap file
use Core\UiEngine\UiEngine;
use Core\UiEngine\ElementFactory;
use App\UiEngine\Elements\DateRangePicker;

// Register the custom element
ElementFactory::register(\'daterange\', DateRangePicker::class);

// Now use it
$picker = UiEngine::fromConfig([
    \'type\' => \'daterange\',
    \'name\' => \'booking_dates\',
    \'label\' => \'Booking Period\',
    \'required\' => true,
]);

// Or create a factory method
UiEngine::macro(\'dateRange\', function($name) {
    return new DateRangePicker($name);
});

// Use the macro
$picker = UiEngine::dateRange(\'booking_dates\')
    ->label(\'Booking Period\')
    ->minDate(date(\'Y-m-d\'))
    ->required();') ?>

<h3 class="heading heading-3">
    <span class="heading-text">Creating a Custom Element (JavaScript)</span>
</h3>

<?= codeBlock('javascript', '// js/ui-engine/elements/form/DateRangePicker.js
import { FormElement } from \'../../core/FormElement.js\';

class DateRangePicker extends FormElement {
    static NAME = \'ui-daterange-picker\';
    static DEFAULTS = {
        ...FormElement.DEFAULTS,
        type: \'daterange\',
        tagName: \'div\',
        format: \'Y-m-d\',
    };

    _initFromConfig(config) {
        super._initFromConfig(config);
        this._startDate = config.startDate || null;
        this._endDate = config.endDate || null;
        this._format = config.format || \'Y-m-d\';
        this._minDate = config.minDate || null;
        this._maxDate = config.maxDate || null;
    }

    startDate(date) { this._startDate = date; return this; }
    endDate(date) { this._endDate = date; return this; }
    format(fmt) { this._format = fmt; return this; }
    minDate(date) { this._minDate = date; return this; }
    maxDate(date) { this._maxDate = date; return this; }

    renderContent() {
        const startName = `${this._name}_start`;
        const endName = `${this._name}_end`;

        return `
            <div class="so-daterange-input">
                <input type="date" class="so-form-control"
                       name="${this._escapeHtml(startName)}"
                       value="${this._escapeHtml(this._startDate || \'\')}"
                       ${this._minDate ? `min="${this._escapeHtml(this._minDate)}"` : \'\'}
                       ${this._maxDate ? `max="${this._escapeHtml(this._maxDate)}"` : \'\'}
                       ${this._required ? \'required\' : \'\'}>
            </div>
            <span class="so-daterange-separator">to</span>
            <div class="so-daterange-input">
                <input type="date" class="so-form-control"
                       name="${this._escapeHtml(endName)}"
                       value="${this._escapeHtml(this._endDate || \'\')}"
                       ${this._minDate ? `min="${this._escapeHtml(this._minDate)}"` : \'\'}
                       ${this._maxDate ? `max="${this._escapeHtml(this._maxDate)}"` : \'\'}
                       ${this._required ? \'required\' : \'\'}>
            </div>
        `;
    }

    toConfig() {
        return {
            ...super.toConfig(),
            startDate: this._startDate,
            endDate: this._endDate,
            format: this._format,
            minDate: this._minDate,
            maxDate: this._maxDate,
        };
    }
}

// Register in UiEngine
UiEngine.register(\'daterange\', DateRangePicker);

export default DateRangePicker;
export { DateRangePicker };') ?>

<!-- AJAX Forms -->
<h2 id="ajax-forms" class="heading heading-2">
    <span class="mdi mdi-cloud-sync heading-icon"></span>
    <span class="heading-text">AJAX Forms</span>
</h2>

<p>
    Handle form submissions via AJAX for seamless user experience.
</p>

<?= codeTabs('ajax', [
    [
        'label' => 'PHP Setup',
        'language' => 'php',
        'code' => '<?php
use Core\UiEngine\UiEngine;

// Enable AJAX mode
$form = UiEngine::form(\'/api/contacts\')
    ->method(\'POST\')
    ->ajax()                    // Enable AJAX submission
    ->id(\'contact-form\')
    ->add(UiEngine::input(\'name\')->label(\'Name\')->required()->rules(\'required|min:2\'))
    ->add(UiEngine::email(\'email\')->label(\'Email\')->required()->rules(\'required|email\'))
    ->add(UiEngine::textarea(\'message\')->label(\'Message\')->required()->rules(\'required|min:10\'))
    ->add(UiEngine::submit(\'Send Message\')->icon(\'send\'));

echo $form->render();
echo $form->exportValidationScript();
?>'
    ],
    [
        'label' => 'JavaScript Events',
        'language' => 'javascript',
        'code' => '// Listen for AJAX form events
const form = document.getElementById(\'contact-form\');

// Before submission
form.addEventListener(\'so:form:before\', (e) => {
    console.log(\'Submitting...\', e.detail);
    // Can cancel with e.preventDefault()
});

// Success response
form.addEventListener(\'so:form:success\', (e) => {
    const { data, response } = e.detail;
    console.log(\'Success!\', data);

    // Show success toast
    SOToast.success(data.message || \'Form submitted successfully!\');

    // Optionally reset form
    form.reset();

    // Or redirect
    if (data.redirect) {
        window.location.href = data.redirect;
    }
});

// Error response (validation or server error)
form.addEventListener(\'so:form:error\', (e) => {
    const { errors, status } = e.detail;
    console.log(\'Error!\', errors);

    // Errors are automatically displayed by ErrorReporter
    // But you can handle them manually:
    if (status === 422) {
        // Validation errors
        Object.keys(errors).forEach(field => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add(\'is-invalid\');
            }
        });
    }
});

// Network error
form.addEventListener(\'so:form:network-error\', (e) => {
    SOToast.error(\'Network error. Please try again.\');
});'
    ],
    [
        'label' => 'API Controller',
        'language' => 'php',
        'code' => '<?php
namespace App\Controllers\Api;

use Core\Http\JsonResponse;
use Core\Validation\Validator;

class ContactApiController
{
    public function store(): JsonResponse
    {
        $validator = new Validator($_POST, [
            \'name\' => \'required|min:2|max:100\',
            \'email\' => \'required|email\',
            \'message\' => \'required|min:10|max:1000\',
        ]);

        if ($validator->fails()) {
            return response()->json([
                \'success\' => false,
                \'errors\' => $validator->errors(),
            ], 422);
        }

        // Process the contact form
        $contact = Contact::create($validator->validated());

        // Send notification email
        // ...

        return response()->json([
            \'success\' => true,
            \'message\' => \'Thank you! We\\\'ll be in touch soon.\',
            \'data\' => [\'id\' => $contact->id],
        ], 201);
    }
}'
    ],
]) ?>

<!-- Dynamic Forms -->
<h2 id="dynamic-forms" class="heading heading-2">
    <span class="mdi mdi-cog-sync heading-icon"></span>
    <span class="heading-text">Dynamic Forms</span>
</h2>

<p>
    Generate forms dynamically from database schemas, JSON configurations, or API responses.
</p>

<?= codeBlock('php', '<?php
use Core\UiEngine\UiEngine;

/**
 * Dynamic Form Builder
 *
 * Generates forms from field definitions stored in database or config files.
 */
class DynamicFormBuilder
{
    private array $fields;
    private string $action;
    private string $method;
    private array $values;

    public function __construct(array $fields, string $action, string $method = \'POST\', array $values = [])
    {
        $this->fields = $fields;
        $this->action = $action;
        $this->method = $method;
        $this->values = $values;
    }

    public function build(): string
    {
        $form = UiEngine::form($this->action)
            ->method($this->method)
            ->id(\'dynamic-form\');

        // Group fields by section
        $sections = $this->groupBySection($this->fields);

        foreach ($sections as $sectionName => $fields) {
            if ($sectionName !== \'_default\') {
                $form->add(UiEngine::divider($sectionName));
            }

            // Process fields in rows
            $currentRow = null;
            foreach ($fields as $field) {
                $element = $this->createElement($field);

                // Handle column layout
                if (!empty($field[\'col\'])) {
                    if (!$currentRow) {
                        $currentRow = UiEngine::row();
                    }
                    $currentRow->add(
                        UiEngine::col($field[\'col\'])->add($element)
                    );

                    // Check if row is complete (12 columns)
                    if ($this->isRowComplete($currentRow)) {
                        $form->add($currentRow);
                        $currentRow = null;
                    }
                } else {
                    // Flush any pending row
                    if ($currentRow) {
                        $form->add($currentRow);
                        $currentRow = null;
                    }
                    $form->add($element);
                }
            }

            // Add any remaining row
            if ($currentRow) {
                $form->add($currentRow);
            }
        }

        // Add submit button
        $form->add(
            UiEngine::submit(empty($this->values) ? \'Create\' : \'Update\')
        );

        return $form->render() . $form->exportValidationScript();
    }

    private function createElement(array $field)
    {
        $element = match($field[\'type\']) {
            \'text\', \'string\' => UiEngine::input($field[\'name\']),
            \'email\' => UiEngine::email($field[\'name\']),
            \'password\' => UiEngine::password($field[\'name\']),
            \'number\', \'integer\' => UiEngine::number($field[\'name\']),
            \'decimal\', \'float\' => UiEngine::number($field[\'name\'])->step(0.01),
            \'textarea\', \'text_long\' => UiEngine::textarea($field[\'name\']),
            \'select\' => UiEngine::select($field[\'name\'])->options($field[\'options\'] ?? []),
            \'checkbox\', \'boolean\' => UiEngine::checkbox($field[\'name\']),
            \'radio\' => UiEngine::radio($field[\'name\'])->options($field[\'options\'] ?? []),
            \'date\' => UiEngine::date($field[\'name\']),
            \'datetime\' => UiEngine::datePicker($field[\'name\'])->withTime(),
            \'time\' => UiEngine::timePicker($field[\'name\']),
            \'file\' => UiEngine::file($field[\'name\']),
            \'hidden\' => UiEngine::hidden($field[\'name\']),
            \'color\' => UiEngine::colorInput($field[\'name\']),
            default => UiEngine::input($field[\'name\']),
        };

        // Apply common attributes
        $this->applyAttributes($element, $field);

        return $element;
    }

    private function applyAttributes($element, array $field): void
    {
        if (!empty($field[\'label\'])) $element->label($field[\'label\']);
        if (!empty($field[\'placeholder\'])) $element->placeholder($field[\'placeholder\']);
        if (!empty($field[\'help\'])) $element->help($field[\'help\']);
        if (!empty($field[\'required\'])) $element->required();
        if (!empty($field[\'disabled\'])) $element->disabled();
        if (!empty($field[\'readonly\'])) $element->readonly();
        if (!empty($field[\'rules\'])) $element->rules($field[\'rules\']);
        if (!empty($field[\'messages\'])) $element->messages($field[\'messages\']);

        // Apply current value
        $name = $field[\'name\'];
        if (isset($this->values[$name])) {
            if ($field[\'type\'] === \'checkbox\' || $field[\'type\'] === \'boolean\') {
                $element->checked((bool) $this->values[$name]);
            } else {
                $element->value($this->values[$name]);
            }
        }
    }

    private function groupBySection(array $fields): array
    {
        $sections = [\'_default\' => []];
        foreach ($fields as $field) {
            $section = $field[\'section\'] ?? \'_default\';
            if (!isset($sections[$section])) {
                $sections[$section] = [];
            }
            $sections[$section][] = $field;
        }
        return $sections;
    }

    private function isRowComplete($row): bool
    {
        // Check if columns add up to 12
        $total = 0;
        foreach ($row->getChildren() as $col) {
            $total += $col->getSize() ?? 12;
        }
        return $total >= 12;
    }
}

// Usage example:
$fields = [
    [\'name\' => \'first_name\', \'type\' => \'text\', \'label\' => \'First Name\', \'col\' => 6, \'required\' => true],
    [\'name\' => \'last_name\', \'type\' => \'text\', \'label\' => \'Last Name\', \'col\' => 6, \'required\' => true],
    [\'name\' => \'email\', \'type\' => \'email\', \'label\' => \'Email\', \'rules\' => \'required|email\'],
    [\'name\' => \'role\', \'type\' => \'select\', \'label\' => \'Role\', \'options\' => [\'admin\' => \'Admin\', \'user\' => \'User\']],
    [\'name\' => \'bio\', \'type\' => \'textarea\', \'label\' => \'Biography\', \'section\' => \'Profile\'],
];

$builder = new DynamicFormBuilder($fields, \'/users\', \'POST\');
echo $builder->build();') ?>

<!-- JavaScript Integration -->
<h2 id="js-integration" class="heading heading-2">
    <span class="mdi mdi-language-javascript heading-icon"></span>
    <span class="heading-text">JavaScript Integration</span>
</h2>

<p>
    Advanced JavaScript patterns for dynamic UI manipulation.
</p>

<?= codeTabs('js-integration', [
    [
        'label' => 'Dynamic UI Updates',
        'language' => 'javascript',
        'code' => '// Dynamically add/remove form fields
class DynamicFieldManager {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.fieldIndex = 0;
    }

    addField(type, config = {}) {
        const element = UiEngine.fromConfig({
            type,
            name: `items[${this.fieldIndex}]`,
            ...config,
        });

        const wrapper = document.createElement(\'div\');
        wrapper.className = \'dynamic-field so-mb-3\';
        wrapper.dataset.index = this.fieldIndex;
        wrapper.innerHTML = `
            <div class="so-d-flex so-align-items-start so-gap-2">
                <div class="so-flex-grow-1">${element.toHtml()}</div>
                <button type="button" class="so-btn so-btn-outline-danger so-btn-sm"
                        onclick="fieldManager.removeField(${this.fieldIndex})">
                    <span class="mdi mdi-delete"></span>
                </button>
            </div>
        `;

        this.container.appendChild(wrapper);
        this.fieldIndex++;
    }

    removeField(index) {
        const field = this.container.querySelector(`[data-index="${index}"]`);
        if (field) {
            field.remove();
        }
    }
}

// Usage
const fieldManager = new DynamicFieldManager(\'fields-container\');

document.getElementById(\'add-field\').addEventListener(\'click\', () => {
    fieldManager.addField(\'input\', {
        label: \'Item\',
        placeholder: \'Enter item name\',
    });
});'
    ],
    [
        'label' => 'Form State Management',
        'language' => 'javascript',
        'code' => '// Manage form state and dirty tracking
class FormStateManager {
    constructor(formId) {
        this.form = document.getElementById(formId);
        this.initialState = this.captureState();
        this.setupWatchers();
    }

    captureState() {
        const formData = new FormData(this.form);
        const state = {};
        for (const [key, value] of formData.entries()) {
            state[key] = value;
        }
        return state;
    }

    isDirty() {
        const currentState = this.captureState();
        return JSON.stringify(this.initialState) !== JSON.stringify(currentState);
    }

    setupWatchers() {
        // Warn on page leave if dirty
        window.addEventListener(\'beforeunload\', (e) => {
            if (this.isDirty()) {
                e.preventDefault();
                e.returnValue = \'You have unsaved changes.\';
                return e.returnValue;
            }
        });

        // Track changes
        this.form.addEventListener(\'input\', () => {
            this.updateDirtyIndicator();
        });
    }

    updateDirtyIndicator() {
        const indicator = this.form.querySelector(\'.dirty-indicator\');
        if (indicator) {
            indicator.style.display = this.isDirty() ? \'inline\' : \'none\';
        }
    }

    reset() {
        this.initialState = this.captureState();
        this.updateDirtyIndicator();
    }
}

// Usage
const formState = new FormStateManager(\'my-form\');

// After successful save
form.addEventListener(\'so:form:success\', () => {
    formState.reset();
});'
    ],
]) ?>

<!-- Server-Side Rendering -->
<h2 id="server-side-rendering" class="heading heading-2">
    <span class="mdi mdi-server heading-icon"></span>
    <span class="heading-text">Server-Side Rendering</span>
</h2>

<p>
    Strategies for efficient server-side rendering with UiEngine.
</p>

<?= codeBlock('php', '<?php
/**
 * Component-based View Rendering
 *
 * Use UiEngine to build reusable view components.
 */

// app/View/Components/UserCard.php
namespace App\View\Components;

use Core\UiEngine\UiEngine;

class UserCard
{
    public static function render(User $user, array $options = []): string
    {
        $showActions = $options[\'showActions\'] ?? true;
        $compact = $options[\'compact\'] ?? false;

        $card = UiEngine::card()
            ->addClass($compact ? \'so-card-sm\' : \'\');

        // Build card body
        $body = UiEngine::mediaObject()
            ->image($user->avatar_url ?: \'/images/default-avatar.png\', $user->name)
            ->imageSize($compact ? \'32px\' : \'64px\')
            ->title($user->name)
            ->body(\'
                <div class="so-text-muted so-small">\' . e($user->email) . \'</div>
                <div class="so-mt-1">
                    <span class="so-badge so-bg-\' . self::getRoleBadgeColor($user->role) . \'">\' . ucfirst($user->role) . \'</span>
                </div>
            \');

        $card->add($body);

        // Add actions if enabled
        if ($showActions) {
            $card->footer(
                UiEngine::flex()
                    ->justify(\'end\')
                    ->gap(2)
                    ->add(UiEngine::button(\'Edit\')->secondary()->small()->href("/users/{$user->id}/edit"))
                    ->add(UiEngine::button(\'View\')->primary()->small()->href("/users/{$user->id}"))
                    ->render()
            );
        }

        return $card->render();
    }

    private static function getRoleBadgeColor(string $role): string
    {
        return match($role) {
            \'admin\' => \'danger\',
            \'manager\' => \'warning\',
            default => \'secondary\',
        };
    }
}

// Usage in views:
<?= UserCard::render($user) ?>
<?= UserCard::render($user, [\'compact\' => true, \'showActions\' => false]) ?>

// In a loop:
<?php foreach ($users as $user): ?>
    <?= UserCard::render($user) ?>
<?php endforeach; ?>') ?>

<!-- Form Builders -->
<h2 id="form-builders" class="heading heading-2">
    <span class="mdi mdi-form-select heading-icon"></span>
    <span class="heading-text">Form Builders</span>
</h2>

<p>
    Create reusable form builders for common patterns.
</p>

<?= codeBlock('php', '<?php
namespace App\Forms;

use Core\UiEngine\UiEngine;

/**
 * Base form builder with common patterns.
 */
abstract class BaseFormBuilder
{
    protected $form;
    protected $model;

    public function __construct($model = null)
    {
        $this->model = $model;
        $this->form = UiEngine::form($this->getAction())
            ->method($this->getMethod())
            ->id($this->getFormId());

        $this->build();
        $this->addButtons();
    }

    abstract protected function build(): void;
    abstract protected function getAction(): string;
    abstract protected function getFormId(): string;

    protected function getMethod(): string
    {
        return $this->model ? \'PUT\' : \'POST\';
    }

    protected function isEdit(): bool
    {
        return $this->model !== null;
    }

    protected function getValue(string $field, $default = null)
    {
        return $this->model?->$field ?? $default;
    }

    protected function addButtons(): void
    {
        $this->form->add(
            UiEngine::row()->addClass(\'so-mt-4\')
                ->add(
                    UiEngine::col(12)->addClass(\'so-d-flex so-gap-2\')
                        ->add(UiEngine::button(\'Cancel\')->secondary()->outline()->attr(\'onclick\', \'history.back()\'))
                        ->add(UiEngine::submit($this->isEdit() ? \'Update\' : \'Create\'))
                )
        );
    }

    public function render(): string
    {
        return $this->form->render() . $this->form->exportValidationScript();
    }
}

/**
 * User form builder.
 */
class UserFormBuilder extends BaseFormBuilder
{
    protected function getAction(): string
    {
        return $this->isEdit() ? "/users/{$this->model->id}" : \'/users\';
    }

    protected function getFormId(): string
    {
        return \'user-form\';
    }

    protected function build(): void
    {
        // Name row
        $this->form->add(
            UiEngine::row()
                ->add(
                    UiEngine::col(6)->add(
                        UiEngine::input(\'first_name\')
                            ->label(\'First Name\')
                            ->value($this->getValue(\'first_name\'))
                            ->required()
                            ->rules(\'required|min:2|max:50\')
                    )
                )
                ->add(
                    UiEngine::col(6)->add(
                        UiEngine::input(\'last_name\')
                            ->label(\'Last Name\')
                            ->value($this->getValue(\'last_name\'))
                            ->required()
                            ->rules(\'required|min:2|max:50\')
                    )
                )
        );

        // Email
        $emailRules = $this->isEdit()
            ? "required|email|unique:users,email,{$this->model->id}"
            : \'required|email|unique:users,email\';

        $this->form->add(
            UiEngine::email(\'email\')
                ->label(\'Email Address\')
                ->value($this->getValue(\'email\'))
                ->required()
                ->rules($emailRules)
        );

        // Role
        $this->form->add(
            UiEngine::select(\'role\')
                ->label(\'Role\')
                ->options([
                    \'admin\' => \'Administrator\',
                    \'manager\' => \'Manager\',
                    \'user\' => \'User\',
                ])
                ->value($this->getValue(\'role\', \'user\'))
                ->required()
        );

        // Password (different for create vs edit)
        if (!$this->isEdit()) {
            $this->form->add(
                UiEngine::row()
                    ->add(
                        UiEngine::col(6)->add(
                            UiEngine::password(\'password\')
                                ->label(\'Password\')
                                ->required()
                                ->rules(\'required|min:8\')
                        )
                    )
                    ->add(
                        UiEngine::col(6)->add(
                            UiEngine::password(\'password_confirmation\')
                                ->label(\'Confirm Password\')
                                ->required()
                        )
                    )
            );
        }
    }
}

// Usage:
// Create page
echo (new UserFormBuilder())->render();

// Edit page
echo (new UserFormBuilder($user))->render();') ?>

<!-- Best Practices -->
<h2 id="best-practices" class="heading heading-2">
    <span class="mdi mdi-check-decagram heading-icon"></span>
    <span class="heading-text">Best Practices</span>
</h2>

<?= callout('success', '
    <strong>Performance Tips:</strong>
    <ul class="so-mb-0">
        <li><strong>Cache form builders:</strong> For complex forms, cache the rendered HTML in request or session</li>
        <li><strong>Lazy load elements:</strong> For dynamic forms, only render visible sections initially</li>
        <li><strong>Minimize validation rules:</strong> Only export client-side validation for user-facing rules</li>
        <li><strong>Use config arrays for data:</strong> When forms are driven by database, use config arrays instead of fluent API</li>
    </ul>
') ?>

<?= callout('info', '
    <strong>Code Organization:</strong>
    <ul class="so-mb-0">
        <li>Keep custom elements in <code>app/UiEngine/Elements/</code></li>
        <li>Keep form builders in <code>app/Forms/</code></li>
        <li>Keep view components in <code>app/View/Components/</code></li>
        <li>Register custom elements in a service provider</li>
    </ul>
') ?>

<?= callout('warning', '
    <strong>Security Considerations:</strong>
    <ul class="so-mb-0">
        <li><strong>Always validate server-side:</strong> Client-side validation can be bypassed</li>
        <li><strong>Escape user content:</strong> Use <code>e()</code> for any user-generated content</li>
        <li><strong>Use CSRF tokens:</strong> Ensure CSRF protection is enabled for all forms</li>
        <li><strong>Validate file uploads:</strong> Check MIME types and sizes server-side</li>
    </ul>
') ?>

<?= callout('info', '
    <strong>See Also:</strong>
    <ul class="so-mb-0">
        <li><a href="/docs/dev-ui-engine">UiEngine Developer Guide</a></li>
        <li><a href="/docs/dev-ui-engine-elements">Element Reference</a></li>
        <li><a href="/docs/validation-system">Validation System</a></li>
    </ul>
') ?>

<?php include __DIR__ . '/../_layout-end.php'; ?>
