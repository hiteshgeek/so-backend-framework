<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Input - Text input form element
 *
 * Supports all HTML5 input types: text, email, password, number,
 * tel, url, search, date, time, datetime-local, month, week, color, range
 */
class Input extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'input';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'input';

    /**
     * Input type attribute
     *
     * @var string
     */
    protected string $inputType = 'text';

    /**
     * Minimum value (for number, date, range)
     *
     * @var mixed
     */
    protected mixed $min = null;

    /**
     * Maximum value (for number, date, range)
     *
     * @var mixed
     */
    protected mixed $max = null;

    /**
     * Step value (for number, range)
     *
     * @var mixed
     */
    protected mixed $step = null;

    /**
     * Maximum length
     *
     * @var int|null
     */
    protected ?int $maxlength = null;

    /**
     * Minimum length
     *
     * @var int|null
     */
    protected ?int $minlength = null;

    /**
     * Pattern for validation
     *
     * @var string|null
     */
    protected ?string $pattern = null;

    /**
     * Autocomplete attribute
     *
     * @var string|null
     */
    protected ?string $autocomplete = null;

    /**
     * Input prefix text/icon
     *
     * @var string|null
     */
    protected ?string $prefix = null;

    /**
     * Input suffix text/icon
     *
     * @var string|null
     */
    protected ?string $suffix = null;

    /**
     * Prefix icon (Material Icons name)
     *
     * @var string|null
     */
    protected ?string $prefixIcon = null;

    /**
     * Suffix icon (Material Icons name)
     *
     * @var string|null
     */
    protected ?string $suffixIcon = null;

    /**
     * Suffix action button configuration
     *
     * @var array|null
     */
    protected ?array $suffixAction = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['inputType'])) {
            $this->inputType = $config['inputType'];
        }

        if (isset($config['min'])) {
            $this->min = $config['min'];
        }

        if (isset($config['max'])) {
            $this->max = $config['max'];
        }

        if (isset($config['step'])) {
            $this->step = $config['step'];
        }

        if (isset($config['maxlength'])) {
            $this->maxlength = (int) $config['maxlength'];
        }

        if (isset($config['minlength'])) {
            $this->minlength = (int) $config['minlength'];
        }

        if (isset($config['pattern'])) {
            $this->pattern = $config['pattern'];
        }

        if (isset($config['autocomplete'])) {
            $this->autocomplete = $config['autocomplete'];
        }

        if (isset($config['prefix'])) {
            $this->prefix = $config['prefix'];
        }

        if (isset($config['suffix'])) {
            $this->suffix = $config['suffix'];
        }

        if (isset($config['prefixIcon'])) {
            $this->prefixIcon = $config['prefixIcon'];
        }

        if (isset($config['suffixIcon'])) {
            $this->suffixIcon = $config['suffixIcon'];
        }

        if (isset($config['suffixAction'])) {
            $this->suffixAction = $config['suffixAction'];
        }
    }

    /**
     * Set the input type
     *
     * @param string $type
     * @return static
     */
    public function inputType(string $type): static
    {
        $this->inputType = $type;
        return $this;
    }

    /**
     * Set as password input
     *
     * @return static
     */
    public function password(): static
    {
        return $this->inputType('password');
    }

    /**
     * Set as telephone input
     *
     * @return static
     */
    public function tel(): static
    {
        return $this->inputType('tel');
    }

    /**
     * Set as search input
     *
     * @return static
     */
    public function search(): static
    {
        return $this->inputType('search');
    }

    /**
     * Set as date input
     *
     * @return static
     */
    public function date(): static
    {
        return $this->inputType('date');
    }

    /**
     * Set as time input
     *
     * @return static
     */
    public function time(): static
    {
        return $this->inputType('time');
    }

    /**
     * Set as datetime-local input
     *
     * @return static
     */
    public function datetime(): static
    {
        return $this->inputType('datetime-local');
    }

    /**
     * Set as month input
     *
     * @return static
     */
    public function month(): static
    {
        return $this->inputType('month');
    }

    /**
     * Set as week input
     *
     * @return static
     */
    public function week(): static
    {
        return $this->inputType('week');
    }

    /**
     * Set as color input
     *
     * @return static
     */
    public function color(): static
    {
        return $this->inputType('color');
    }

    /**
     * Set as range input
     *
     * @return static
     */
    public function range(): static
    {
        return $this->inputType('range');
    }

    /**
     * Set minimum value (HTML attribute)
     *
     * @param int|float|string $min Minimum value
     * @return static
     */
    public function minValue(mixed $min): static
    {
        $this->min = $min;
        return $this;
    }

    /**
     * Set maximum value (HTML attribute)
     *
     * @param int|float|string $max Maximum value
     * @return static
     */
    public function maxValue(mixed $max): static
    {
        $this->max = $max;
        return $this;
    }

    /**
     * Set step value
     *
     * @param mixed $step
     * @return static
     */
    public function step(mixed $step): static
    {
        $this->step = $step;
        return $this;
    }

    /**
     * Set maximum length
     *
     * @param int $maxlength
     * @return static
     */
    public function maxlength(int $maxlength): static
    {
        $this->maxlength = $maxlength;
        return $this;
    }

    /**
     * Set minimum length
     *
     * @param int $minlength
     * @return static
     */
    public function minlength(int $minlength): static
    {
        $this->minlength = $minlength;
        return $this;
    }

    /**
     * Set validation pattern (HTML attribute)
     *
     * @param string $pattern Regex pattern
     * @return static
     */
    public function inputPattern(string $pattern): static
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Set autocomplete attribute
     *
     * @param string $autocomplete
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
     * Set input prefix
     *
     * @param string $prefix
     * @return static
     */
    public function prefix(string $prefix): static
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * Set input suffix
     *
     * @param string $suffix
     * @return static
     */
    public function suffix(string $suffix): static
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * Set prefix icon
     *
     * @param string $icon Material Icons name
     * @return static
     */
    public function prefixIcon(string $icon): static
    {
        $this->prefixIcon = $icon;
        return $this;
    }

    /**
     * Set suffix icon
     *
     * @param string $icon Material Icons name
     * @return static
     */
    public function suffixIcon(string $icon): static
    {
        $this->suffixIcon = $icon;
        return $this;
    }

    /**
     * Set suffix action button
     *
     * @param string $icon Material Icons name
     * @param string $action JavaScript function or event handler
     * @return static
     */
    public function suffixAction(string $icon, string $action = ''): static
    {
        $this->suffixAction = [
            'icon' => $icon,
            'action' => $action
        ];
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

        $attrs['type'] = $this->inputType;

        if ($this->min !== null) {
            $attrs['min'] = $this->min;
        }

        if ($this->max !== null) {
            $attrs['max'] = $this->max;
        }

        if ($this->step !== null) {
            $attrs['step'] = $this->step;
        }

        if ($this->maxlength !== null) {
            $attrs['maxlength'] = $this->maxlength;
        }

        if ($this->minlength !== null) {
            $attrs['minlength'] = $this->minlength;
        }

        if ($this->pattern !== null) {
            $attrs['pattern'] = $this->pattern;
        }

        if ($this->autocomplete !== null) {
            $attrs['autocomplete'] = $this->autocomplete;
        }

        return $attrs;
    }

    /**
     * Render the complete element with addons
     *
     * @return string
     */
    public function render(): string
    {
        // Check if we need any wrapper
        $hasTextAddon = $this->prefix !== null || $this->suffix !== null;
        $hasIconAddon = $this->prefixIcon !== null || $this->suffixIcon !== null || $this->suffixAction !== null;

        // If no addons at all, render normally
        if (!$hasTextAddon && !$hasIconAddon) {
            return parent::render();
        }

        $html = '';

        // Icon wrapper (for icons and icon actions)
        if ($hasIconAddon) {
            $wrapperClass = CssPrefix::cls('input-wrapper');
            $html .= '<div class="' . $wrapperClass . '">';

            // Prefix icon
            if ($this->prefixIcon !== null) {
                $html .= '<span class="' . CssPrefix::cls('input-icon') . '">';
                $html .= '<span class="material-icons">' . e($this->prefixIcon) . '</span>';
                $html .= '</span>';
            }

            // The input element
            $html .= parent::render();

            // Suffix icon
            if ($this->suffixIcon !== null) {
                $html .= '<span class="' . CssPrefix::cls('input-icon') . '">';
                $html .= '<span class="material-icons">' . e($this->suffixIcon) . '</span>';
                $html .= '</span>';
            }

            // Suffix action button
            if ($this->suffixAction !== null) {
                $html .= '<button type="button" class="' . CssPrefix::cls('input-action') . '"';
                if (!empty($this->suffixAction['action'])) {
                    $html .= ' onclick="' . e($this->suffixAction['action']) . '"';
                }
                $html .= ' aria-label="Action">';
                $html .= '<span class="material-icons">' . e($this->suffixAction['icon']) . '</span>';
                $html .= '</button>';
            }

            $html .= '</div>';
        }
        // Text addon wrapper (for text prefix/suffix)
        elseif ($hasTextAddon) {
            $html .= '<div class="' . CssPrefix::cls('input-group') . '">';

            if ($this->prefix !== null) {
                $html .= '<span class="' . CssPrefix::cls('input-group-text') . '">' . e($this->prefix) . '</span>';
            }

            $html .= parent::render();

            if ($this->suffix !== null) {
                $html .= '<span class="' . CssPrefix::cls('input-group-text') . '">' . e($this->suffix) . '</span>';
            }

            $html .= '</div>';
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

        if ($this->inputType !== 'text') {
            $config['inputType'] = $this->inputType;
        }

        if ($this->min !== null) {
            $config['min'] = $this->min;
        }

        if ($this->max !== null) {
            $config['max'] = $this->max;
        }

        if ($this->step !== null) {
            $config['step'] = $this->step;
        }

        if ($this->maxlength !== null) {
            $config['maxlength'] = $this->maxlength;
        }

        if ($this->minlength !== null) {
            $config['minlength'] = $this->minlength;
        }

        if ($this->pattern !== null) {
            $config['pattern'] = $this->pattern;
        }

        if ($this->autocomplete !== null) {
            $config['autocomplete'] = $this->autocomplete;
        }

        if ($this->prefix !== null) {
            $config['prefix'] = $this->prefix;
        }

        if ($this->suffix !== null) {
            $config['suffix'] = $this->suffix;
        }

        if ($this->prefixIcon !== null) {
            $config['prefixIcon'] = $this->prefixIcon;
        }

        if ($this->suffixIcon !== null) {
            $config['suffixIcon'] = $this->suffixIcon;
        }

        if ($this->suffixAction !== null) {
            $config['suffixAction'] = $this->suffixAction;
        }

        return $config;
    }
}
