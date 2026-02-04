<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Autocomplete - Search input with suggestions
 *
 * Provides typeahead/autocomplete functionality with AJAX or static options
 * Supports single/multi-select, async data, free solo mode, and token display
 */
class Autocomplete extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'autocomplete';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Static options for suggestions
     *
     * @var array
     */
    protected array $options = [];

    /**
     * AJAX URL for fetching suggestions
     *
     * @var string|null
     */
    protected ?string $asyncUrl = null;

    /**
     * Minimum characters before search
     *
     * @var int
     */
    protected int $minLength = 0;

    /**
     * Debounce delay in milliseconds
     *
     * @var int
     */
    protected int $debounce = 300;

    /**
     * Maximum suggestions to display
     *
     * @var int
     */
    protected int $maxResults = 10;

    /**
     * Allow free text input (not from suggestions)
     *
     * @var bool
     */
    protected bool $freeSolo = false;

    /**
     * Highlight matching text in suggestions
     *
     * @var bool
     */
    protected bool $highlightMatches = true;

    /**
     * Show clear button
     *
     * @var bool
     */
    protected bool $clearable = true;

    /**
     * Enable multiple selection
     *
     * @var bool
     */
    protected bool $multiple = false;

    /**
     * Display mode for multiple selection
     *
     * @var string chips|text|chips-overflow
     */
    protected string $displayMode = 'chips';

    /**
     * Maximum visible tokens before "+N more"
     *
     * @var int
     */
    protected int $maxVisibleTokens = 3;

    /**
     * Token delimiters for free solo mode
     *
     * @var array
     */
    protected array $tokenDelimiters = [',', ';'];

    /**
     * No results text
     *
     * @var string
     */
    protected string $noResultsText = 'No results found';

    /**
     * Loading text
     *
     * @var string
     */
    protected string $loadingText = 'Loading...';

    /**
     * Custom item template
     *
     * @var string|null
     */
    protected ?string $itemTemplate = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['options'])) {
            $this->options = $config['options'];
        }

        if (isset($config['asyncUrl']) || isset($config['async'])) {
            $this->asyncUrl = $config['asyncUrl'] ?? $config['async'];
        }

        if (isset($config['minLength']) || isset($config['minChars'])) {
            $this->minLength = (int) ($config['minLength'] ?? $config['minChars']);
        }

        if (isset($config['debounce'])) {
            $this->debounce = (int) $config['debounce'];
        }

        if (isset($config['maxResults'])) {
            $this->maxResults = (int) $config['maxResults'];
        }

        if (isset($config['freeSolo'])) {
            $this->freeSolo = (bool) $config['freeSolo'];
        }

        if (isset($config['highlightMatches'])) {
            $this->highlightMatches = (bool) $config['highlightMatches'];
        }

        if (isset($config['clearable'])) {
            $this->clearable = (bool) $config['clearable'];
        }

        if (isset($config['multiple'])) {
            $this->multiple = (bool) $config['multiple'];
        }

        if (isset($config['displayMode'])) {
            $this->displayMode = $config['displayMode'];
        }

        if (isset($config['maxVisibleTokens'])) {
            $this->maxVisibleTokens = (int) $config['maxVisibleTokens'];
        }

        if (isset($config['tokenDelimiters'])) {
            $this->tokenDelimiters = $config['tokenDelimiters'];
        }

        if (isset($config['itemTemplate'])) {
            $this->itemTemplate = $config['itemTemplate'];
        }
    }

    /**
     * Set static options
     *
     * @param array $options
     * @return static
     */
    public function options(array $options): static
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Add single option
     *
     * @param string|array $option
     * @return static
     */
    public function addOption(string|array $option): static
    {
        $this->options[] = $option;
        return $this;
    }

    /**
     * Set async URL for fetching suggestions
     *
     * @param string $url
     * @return static
     */
    public function async(string $url): static
    {
        $this->asyncUrl = $url;
        return $this;
    }

    /**
     * Alias for async()
     *
     * @param string $url
     * @return static
     */
    public function ajaxUrl(string $url): static
    {
        return $this->async($url);
    }

    /**
     * Set minimum characters before search
     *
     * @param int $length
     * @return static
     */
    public function minLength(int $length): static
    {
        $this->minLength = $length;
        return $this;
    }

    /**
     * Alias for minLength()
     *
     * @param int $chars
     * @return static
     */
    public function minChars(int $chars): static
    {
        return $this->minLength($chars);
    }

    /**
     * Set debounce delay
     *
     * @param int $ms
     * @return static
     */
    public function debounce(int $ms): static
    {
        $this->debounce = $ms;
        return $this;
    }

    /**
     * Set maximum results to display
     *
     * @param int $max
     * @return static
     */
    public function maxResults(int $max): static
    {
        $this->maxResults = $max;
        return $this;
    }

    /**
     * Enable free solo mode (allow custom values)
     *
     * @param bool $freeSolo
     * @return static
     */
    public function freeSolo(bool $freeSolo = true): static
    {
        $this->freeSolo = $freeSolo;
        return $this;
    }

    /**
     * Require selection from suggestions (disable free solo)
     *
     * @return static
     */
    public function strict(): static
    {
        return $this->freeSolo(false);
    }

    /**
     * Set highlight matching text
     *
     * @param bool $highlight
     * @return static
     */
    public function highlightMatches(bool $highlight = true): static
    {
        $this->highlightMatches = $highlight;
        return $this;
    }

    /**
     * Alias for highlightMatches()
     *
     * @param bool $highlight
     * @return static
     */
    public function highlight(bool $highlight = true): static
    {
        return $this->highlightMatches($highlight);
    }

    /**
     * Set clearable
     *
     * @param bool $clearable
     * @return static
     */
    public function clearable(bool $clearable = true): static
    {
        $this->clearable = $clearable;
        return $this;
    }

    /**
     * Enable multiple selection
     *
     * @param bool $multiple
     * @return static
     */
    public function multiple(bool $multiple = true): static
    {
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * Set display mode for multiple selection
     *
     * @param string $mode chips|text|chips-overflow
     * @return static
     */
    public function displayMode(string $mode): static
    {
        $this->displayMode = $mode;
        return $this;
    }

    /**
     * Set maximum visible tokens
     *
     * @param int $max
     * @return static
     */
    public function maxVisibleTokens(int $max): static
    {
        $this->maxVisibleTokens = $max;
        return $this;
    }

    /**
     * Set token delimiters for free solo mode
     *
     * @param array $delimiters
     * @return static
     */
    public function tokenDelimiters(array $delimiters): static
    {
        $this->tokenDelimiters = $delimiters;
        return $this;
    }

    /**
     * Set no results text
     *
     * @param string $text
     * @return static
     */
    public function noResultsText(string $text): static
    {
        $this->noResultsText = $text;
        return $this;
    }

    /**
     * Set loading text
     *
     * @param string $text
     * @return static
     */
    public function loadingText(string $text): static
    {
        $this->loadingText = $text;
        return $this;
    }

    /**
     * Set custom item template
     *
     * @param string $template
     * @return static
     */
    public function itemTemplate(string $template): static
    {
        $this->itemTemplate = $template;
        return $this;
    }

    /**
     * Override to prevent adding so-form-control class
     * Autocomplete is a complex component with its own wrapper structure
     *
     * @return void
     */
    protected function addBaseClasses(): void
    {
        // Do not add form-control class - autocomplete has custom structure
    }

    /**
     * Build CSS class string for wrapper
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('autocomplete'));

        if ($this->multiple) {
            $this->addClass(CssPrefix::cls('autocomplete-multiple'));
            $this->addClass(CssPrefix::cls('autocomplete-display-' . $this->displayMode));
        }

        if ($this->size) {
            $this->addClass(CssPrefix::cls('autocomplete-' . $this->size));
        }

        if ($this->disabled) {
            $this->addClass(CssPrefix::cls('disabled'));
        }

        return parent::buildClassString();
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = [];

        if ($this->id) {
            $attrs['id'] = $this->id;
        }

        $attrs['class'] = $this->buildClassString();

        // Add autocomplete initialization attribute
        $attrs[CssPrefix::data('autocomplete')] = true;

        // Data attributes for JS initialization
        if ($this->multiple) {
            $attrs[CssPrefix::data('multiple')] = 'true';
        }

        if ($this->freeSolo) {
            $attrs[CssPrefix::data('free-solo')] = 'true';
        }

        if ($this->asyncUrl) {
            $attrs[CssPrefix::data('async')] = $this->asyncUrl;
        }

        // Add options data if static options provided
        if (!empty($this->options)) {
            $attrs[CssPrefix::data('options')] = json_encode($this->options);
        }

        // Add configuration
        if ($this->minLength > 0) {
            $attrs[CssPrefix::data('min-length')] = $this->minLength;
        }

        if ($this->clearable) {
            $attrs[CssPrefix::data('clearable')] = 'true';
        }

        return $attrs;
    }

    /**
     * Render the complete element
     *
     * @return string
     */
    public function render(): string
    {
        $attrs = $this->gatherAllAttributes();
        $attrString = $this->buildAttributeString($attrs);

        $containerId = 'autocomplete-' . ($this->id ?? uniqid());
        $dropdownId = $containerId . '-dropdown';

        // Build input area
        $inputHtml = $this->renderInput($dropdownId);

        // Build container
        $html = '<div ' . $attrString . '>';

        // Container wrapper
        $html .= '<div class="' . CssPrefix::cls('autocomplete-container') . '" id="' . $containerId . '">';

        // Multiple mode has tokens container
        if ($this->multiple) {
            $html .= '<div class="' . CssPrefix::cls('autocomplete-tokens') . '">';
            $html .= $inputHtml;
            $html .= '</div>';
        } else {
            $html .= $inputHtml;
        }

        // Clear button
        if ($this->clearable) {
            $html .= '<button type="button" class="' . CssPrefix::cls('autocomplete-clear') . '" style="display: none;" aria-label="Clear all">';
            $html .= '<span class="material-icons">close</span>';
            $html .= '</button>';
        }

        // Arrow
        $html .= '<span class="' . CssPrefix::cls('autocomplete-arrow') . '">';
        $html .= '<span class="material-icons">expand_more</span>';
        $html .= '</span>';

        $html .= '</div>'; // End container

        // Dropdown
        $html .= '<div class="' . CssPrefix::cls('autocomplete-dropdown') . '" id="' . $dropdownId . '" role="listbox">';

        // Loading indicator
        $html .= '<div class="' . CssPrefix::cls('autocomplete-loading') . '" style="display: none;">';
        $html .= '<span class="' . CssPrefix::cls('spinner') . ' ' . CssPrefix::cls('spinner-sm') . '"></span>';
        $html .= '<span>' . htmlspecialchars($this->loadingText) . '</span>';
        $html .= '</div>';

        // Options container
        $html .= '<div class="' . CssPrefix::cls('autocomplete-options') . '"></div>';

        // No results
        $html .= '<div class="' . CssPrefix::cls('autocomplete-no-results') . '" style="display: none;">';
        $html .= htmlspecialchars($this->noResultsText);
        $html .= '</div>';

        $html .= '</div>'; // End dropdown

        $html .= '</div>'; // End wrapper

        return $html;
    }

    /**
     * Render the input element
     *
     * @param string $dropdownId
     * @return string
     */
    protected function renderInput(string $dropdownId): string
    {
        $inputClass = CssPrefix::cls('autocomplete-input');

        $attrs = [
            'type' => 'text',
            'class' => $inputClass,
            'placeholder' => $this->placeholder ?? 'Type to search...',
            'autocomplete' => 'off',
            'role' => 'combobox',
            'aria-expanded' => 'false',
            'aria-haspopup' => 'listbox',
            'aria-owns' => $dropdownId,
            'aria-autocomplete' => 'list',
        ];

        if ($this->name) {
            // For multiple, use hidden inputs for values
            if (!$this->multiple) {
                $attrs['name'] = $this->name;
            }
        }

        if ($this->disabled) {
            $attrs['disabled'] = 'disabled';
        }

        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        $attrString = $this->buildAttributeString($attrs);
        return '<input ' . $attrString . '>';
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if (!empty($this->options)) {
            $config['options'] = $this->options;
        }

        if ($this->asyncUrl !== null) {
            $config['async'] = $this->asyncUrl;
        }

        if ($this->minLength !== 0) {
            $config['minLength'] = $this->minLength;
        }

        if ($this->debounce !== 300) {
            $config['debounce'] = $this->debounce;
        }

        if ($this->maxResults !== 10) {
            $config['maxResults'] = $this->maxResults;
        }

        if ($this->freeSolo) {
            $config['freeSolo'] = true;
        }

        if (!$this->highlightMatches) {
            $config['highlightMatches'] = false;
        }

        if (!$this->clearable) {
            $config['clearable'] = false;
        }

        if ($this->multiple) {
            $config['multiple'] = true;
        }

        if ($this->displayMode !== 'chips') {
            $config['displayMode'] = $this->displayMode;
        }

        if ($this->maxVisibleTokens !== 3) {
            $config['maxVisibleTokens'] = $this->maxVisibleTokens;
        }

        if ($this->tokenDelimiters !== [',', ';']) {
            $config['tokenDelimiters'] = $this->tokenDelimiters;
        }

        if ($this->itemTemplate !== null) {
            $config['itemTemplate'] = $this->itemTemplate;
        }

        return $config;
    }
}
