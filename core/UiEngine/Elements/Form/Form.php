<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Traits\HasEvents;
use Core\UiEngine\Validation\ClientRuleExporter;
use Core\UiEngine\Support\CssPrefix;

/**
 * Form - Form container element
 *
 * Creates a form element with support for nested layouts,
 * validation, and AJAX submission.
 */
class Form extends ContainerElement
{
    use HasEvents;

    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'form';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'form';

    /**
     * Form action URL
     *
     * @var string|null
     */
    protected ?string $action = null;

    /**
     * Form method
     *
     * @var string
     */
    protected string $method = 'POST';

    /**
     * Form encoding type
     *
     * @var string|null
     */
    protected ?string $enctype = null;

    /**
     * Form target
     *
     * @var string|null
     */
    protected ?string $target = null;

    /**
     * Disable browser validation
     *
     * @var bool
     */
    protected bool $novalidate = false;

    /**
     * Autocomplete setting
     *
     * @var string|null
     */
    protected ?string $autocomplete = null;

    /**
     * CSRF token
     *
     * @var string|null
     */
    protected ?string $csrfToken = null;

    /**
     * CSRF token field name
     *
     * @var string
     */
    protected string $csrfFieldName = '_token';

    /**
     * HTTP method override (for PUT, PATCH, DELETE)
     *
     * @var string|null
     */
    protected ?string $methodOverride = null;

    /**
     * Enable AJAX submission
     *
     * @var bool
     */
    protected bool $ajax = false;

    /**
     * Show loading state on submit
     *
     * @var bool
     */
    protected bool $showLoading = true;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['action'])) {
            $this->action = $config['action'];
        }

        if (isset($config['method'])) {
            $this->method($config['method']);
        }

        if (isset($config['enctype'])) {
            $this->enctype = $config['enctype'];
        }

        if (isset($config['target'])) {
            $this->target = $config['target'];
        }

        if (isset($config['novalidate'])) {
            $this->novalidate = (bool) $config['novalidate'];
        }

        if (isset($config['autocomplete'])) {
            $this->autocomplete = $config['autocomplete'];
        }

        if (isset($config['csrfToken'])) {
            $this->csrfToken = $config['csrfToken'];
        }

        if (isset($config['csrfFieldName'])) {
            $this->csrfFieldName = $config['csrfFieldName'];
        }

        if (isset($config['ajax'])) {
            $this->ajax = (bool) $config['ajax'];
        }

        if (isset($config['showLoading'])) {
            $this->showLoading = (bool) $config['showLoading'];
        }

        // Event handlers
        if (isset($config['events']) && is_array($config['events'])) {
            $this->onMany($config['events']);
        }
    }

    /**
     * Set form action
     *
     * @param string $action
     * @return static
     */
    public function action(string $action): static
    {
        $this->action = $action;
        return $this;
    }

    /**
     * Set form method
     *
     * @param string $method GET|POST|PUT|PATCH|DELETE
     * @return static
     */
    public function method(string $method): static
    {
        $method = strtoupper($method);

        // HTML forms only support GET and POST
        // Other methods need override
        if (in_array($method, ['PUT', 'PATCH', 'DELETE'])) {
            $this->method = 'POST';
            $this->methodOverride = $method;
        } else {
            $this->method = $method;
            $this->methodOverride = null;
        }

        return $this;
    }

    /**
     * Set as GET form
     *
     * @return static
     */
    public function get(): static
    {
        return $this->method('GET');
    }

    /**
     * Set as POST form
     *
     * @return static
     */
    public function post(): static
    {
        return $this->method('POST');
    }

    /**
     * Set as PUT form (uses method override)
     *
     * @return static
     */
    public function put(): static
    {
        return $this->method('PUT');
    }

    /**
     * Set as PATCH form (uses method override)
     *
     * @return static
     */
    public function patch(): static
    {
        return $this->method('PATCH');
    }

    /**
     * Set as DELETE form (uses method override)
     *
     * @return static
     */
    public function delete(): static
    {
        return $this->method('DELETE');
    }

    /**
     * Set encoding type
     *
     * @param string $enctype
     * @return static
     */
    public function enctype(string $enctype): static
    {
        $this->enctype = $enctype;
        return $this;
    }

    /**
     * Enable multipart encoding (for file uploads)
     *
     * @return static
     */
    public function multipart(): static
    {
        return $this->enctype('multipart/form-data');
    }

    /**
     * Set form target
     *
     * @param string $target
     * @return static
     */
    public function target(string $target): static
    {
        $this->target = $target;
        return $this;
    }

    /**
     * Open in new tab
     *
     * @return static
     */
    public function newTab(): static
    {
        return $this->target('_blank');
    }

    /**
     * Disable browser validation
     *
     * @param bool $novalidate
     * @return static
     */
    public function novalidate(bool $novalidate = true): static
    {
        $this->novalidate = $novalidate;
        return $this;
    }

    /**
     * Set autocomplete
     *
     * @param string $autocomplete on|off
     * @return static
     */
    public function autocomplete(string $autocomplete): static
    {
        $this->autocomplete = $autocomplete;
        return $this;
    }

    /**
     * Disable autocomplete
     *
     * @return static
     */
    public function noAutocomplete(): static
    {
        return $this->autocomplete('off');
    }

    /**
     * Set CSRF token
     *
     * @param string $token
     * @param string $fieldName
     * @return static
     */
    public function csrf(string $token, string $fieldName = '_token'): static
    {
        $this->csrfToken = $token;
        $this->csrfFieldName = $fieldName;
        return $this;
    }

    /**
     * Enable AJAX submission
     *
     * @param bool $ajax
     * @return static
     */
    public function ajax(bool $ajax = true): static
    {
        $this->ajax = $ajax;
        return $this;
    }

    /**
     * Set loading state behavior
     *
     * @param bool $show
     * @return static
     */
    public function showLoading(bool $show = true): static
    {
        $this->showLoading = $show;
        return $this;
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        if ($this->action !== null) {
            $attrs['action'] = $this->action;
        }

        $attrs['method'] = $this->method;

        if ($this->enctype !== null) {
            $attrs['enctype'] = $this->enctype;
        }

        if ($this->target !== null) {
            $attrs['target'] = $this->target;
        }

        if ($this->novalidate) {
            $attrs['novalidate'] = true;
        }

        if ($this->autocomplete !== null) {
            $attrs['autocomplete'] = $this->autocomplete;
        }

        if ($this->ajax) {
            $attrs[CssPrefix::data('ajax')] = 'true';
        }

        if (!$this->showLoading) {
            $attrs[CssPrefix::data('no-loading')] = 'true';
        }

        // Event attributes
        $attrs = array_merge($attrs, $this->buildEventAttributes());

        return $attrs;
    }

    /**
     * Render form children (FormElements use renderGroup())
     *
     * @return string
     */
    public function renderChildren(): string
    {
        $html = '';

        foreach ($this->children as $child) {
            // FormElements with labels should use renderGroup() for proper wrapper
            if ($child instanceof FormElement) {
                $label = $child->getLabel();
                if ($label !== null) {
                    // Ensure FormElement has an ID for label linking
                    if ($child->getId() === null) {
                        $name = $child->getName();
                        if ($name !== null) {
                            $child->id($name);
                        }
                    }
                    $html .= $child->renderGroup();
                } else {
                    $html .= $child->render();
                }
            } else {
                $html .= $child->render();
            }
        }

        return $html;
    }

    /**
     * Render form content including hidden fields
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Method override hidden field
        if ($this->methodOverride !== null) {
            $html .= '<input type="hidden" name="_method" value="' . e($this->methodOverride) . '">';
        }

        // CSRF token hidden field
        if ($this->csrfToken !== null) {
            $html .= '<input type="hidden" name="' . e($this->csrfFieldName) . '" value="' . e($this->csrfToken) . '">';
        }

        // Children
        $html .= $this->renderChildren();

        return $html;
    }

    /**
     * Export validation rules for JavaScript
     *
     * @return array
     */
    public function exportValidation(): array
    {
        return parent::exportValidation();
    }

    /**
     * Export validation rules as script tag
     *
     * @return string
     */
    public function exportValidationScript(): string
    {
        $rules = $this->exportValidation();

        if (empty($rules)) {
            return '';
        }

        $formId = $this->id ?? 'form';
        $json = json_encode($rules, JSON_PRETTY_PRINT);

        return sprintf(
            '<script>document.addEventListener("DOMContentLoaded", function() { UiEngine.loadValidation("%s", %s); });</script>',
            e($formId),
            $json
        );
    }

    /**
     * Render the complete form with validation script
     *
     * @param bool $includeValidation Include validation script
     * @return string
     */
    public function renderWithValidation(bool $includeValidation = true): string
    {
        $html = $this->render();

        if ($includeValidation) {
            $html .= $this->exportValidationScript();
        }

        return $html;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->action !== null) {
            $config['action'] = $this->action;
        }

        $config['method'] = $this->methodOverride ?? $this->method;

        if ($this->enctype !== null) {
            $config['enctype'] = $this->enctype;
        }

        if ($this->target !== null) {
            $config['target'] = $this->target;
        }

        if ($this->novalidate) {
            $config['novalidate'] = true;
        }

        if ($this->autocomplete !== null) {
            $config['autocomplete'] = $this->autocomplete;
        }

        if ($this->ajax) {
            $config['ajax'] = true;
        }

        if (!$this->showLoading) {
            $config['showLoading'] = false;
        }

        if (!empty($this->events)) {
            $config['events'] = $this->events;
        }

        return $config;
    }
}
