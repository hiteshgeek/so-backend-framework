<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Slider - Range slider input
 *
 * A styled range slider with optional dual handles for range selection.
 * Generates the following DOM structure:
 *
 * <div class="so-slider so-slider-primary" data-so-slider>
 *     <input type="range" class="so-slider-input" min="0" max="100" value="50">
 *     <div class="so-slider-track">
 *         <div class="so-slider-fill"></div>
 *         <div class="so-slider-thumb"></div>
 *     </div>
 * </div>
 */
class Slider extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'slider';

    /**
     * HTML tag name (wrapper div, not the input)
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Minimum value
     *
     * @var int|float
     */
    protected int|float $min = 0;

    /**
     * Maximum value
     *
     * @var int|float
     */
    protected int|float $max = 100;

    /**
     * Step value
     *
     * @var int|float
     */
    protected int|float $step = 1;

    /**
     * Range mode (dual handles)
     *
     * @var bool
     */
    protected bool $isRangeSlider = false;

    /**
     * Second value (for range mode)
     *
     * @var int|float|null
     */
    protected int|float|null $valueEnd = null;

    /**
     * Show value tooltip
     *
     * @var bool
     */
    protected bool $showTooltip = false;

    /**
     * Number of tick marks
     *
     * @var int
     */
    protected int $tickCount = 0;

    /**
     * Slider variant/color
     *
     * @var string
     */
    protected string $variant = 'primary';

    /**
     * Slider size (xs, sm, default, lg)
     *
     * @var string|null
     */
    protected ?string $size = null;

    /**
     * Vertical orientation
     *
     * @var bool
     */
    protected bool $vertical = false;

    /**
     * Value format/suffix
     *
     * @var string|null
     */
    protected ?string $suffix = null;

    /**
     * Value prefix
     *
     * @var string|null
     */
    protected ?string $prefix = null;

    /**
     * External output element selector
     *
     * @var string|null
     */
    protected ?string $output = null;

    /**
     * Range value separator
     *
     * @var string
     */
    protected string $separator = ' - ';

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['min'])) {
            $this->min = $config['min'];
        }

        if (isset($config['max'])) {
            $this->max = $config['max'];
        }

        if (isset($config['step'])) {
            $this->step = $config['step'];
        }

        if (isset($config['range'])) {
            $this->isRangeSlider = (bool) $config['range'];
        }

        if (isset($config['valueEnd'])) {
            $this->valueEnd = $config['valueEnd'];
            $this->isRangeSlider = true;
        }

        if (isset($config['showTooltip'])) {
            $this->showTooltip = (bool) $config['showTooltip'];
        }

        if (isset($config['ticks'])) {
            $this->tickCount = (int) $config['ticks'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        if (isset($config['vertical'])) {
            $this->vertical = (bool) $config['vertical'];
        }

        if (isset($config['suffix'])) {
            $this->suffix = $config['suffix'];
        }

        if (isset($config['prefix'])) {
            $this->prefix = $config['prefix'];
        }

        if (isset($config['output'])) {
            $this->output = $config['output'];
        }

        if (isset($config['separator'])) {
            $this->separator = $config['separator'];
        }
    }

    /**
     * Set minimum value for the slider range
     *
     * @param int|float $value
     * @return static
     */
    public function minValue(int|float $value): static
    {
        $this->min = $value;
        return $this;
    }

    /**
     * Set maximum value for the slider range
     *
     * @param int|float $value
     * @return static
     */
    public function maxValue(int|float $value): static
    {
        $this->max = $value;
        return $this;
    }

    /**
     * Set step value
     *
     * @param int|float $step
     * @return static
     */
    public function step(int|float $step): static
    {
        $this->step = $step;
        return $this;
    }

    /**
     * Set value range (min, max, step)
     *
     * @param int|float $min
     * @param int|float $max
     * @param int|float $step
     * @return static
     */
    public function range(int|float $min, int|float $max, int|float $step = 1): static
    {
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        return $this;
    }

    /**
     * Enable dual handle range mode
     *
     * @param bool $enabled
     * @return static
     */
    public function dualRange(bool $enabled = true): static
    {
        $this->isRangeSlider = $enabled;
        return $this;
    }

    /**
     * Set end value (for range mode)
     *
     * @param int|float $value
     * @return static
     */
    public function valueEnd(int|float $value): static
    {
        $this->valueEnd = $value;
        $this->isRangeSlider = true;
        return $this;
    }

    /**
     * Show value tooltip on hover/focus
     * Adds .so-slider-labeled class and tooltip element inside thumb
     *
     * @param bool $show
     * @return static
     */
    public function showTooltip(bool $show = true): static
    {
        $this->showTooltip = $show;
        return $this;
    }

    /**
     * Alias for showTooltip(true)
     *
     * @return static
     */
    public function labeled(): static
    {
        return $this->showTooltip(true);
    }

    /**
     * Set number of tick marks
     * Adds .so-slider-discrete class
     *
     * @param int $count
     * @return static
     */
    public function ticks(int $count): static
    {
        $this->tickCount = $count;
        return $this;
    }

    /**
     * Set variant/color
     *
     * @param string $variant primary|secondary|success|danger|warning|info|light|dark
     * @return static
     */
    public function variant(string $variant): static
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * Primary variant
     *
     * @return static
     */
    public function primary(): static
    {
        return $this->variant('primary');
    }

    /**
     * Secondary variant
     *
     * @return static
     */
    public function secondary(): static
    {
        return $this->variant('secondary');
    }

    /**
     * Success variant
     *
     * @return static
     */
    public function success(): static
    {
        return $this->variant('success');
    }

    /**
     * Danger variant
     *
     * @return static
     */
    public function danger(): static
    {
        return $this->variant('danger');
    }

    /**
     * Warning variant
     *
     * @return static
     */
    public function warning(): static
    {
        return $this->variant('warning');
    }

    /**
     * Info variant
     *
     * @return static
     */
    public function info(): static
    {
        return $this->variant('info');
    }

    /**
     * Set slider size
     *
     * @param string $size xs|sm|lg
     * @return static
     */
    public function size(string $size): static
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Extra small size
     *
     * @return static
     */
    public function xs(): static
    {
        return $this->size('xs');
    }

    /**
     * Small size
     *
     * @return static
     */
    public function sm(): static
    {
        return $this->size('sm');
    }

    /**
     * Large size
     *
     * @return static
     */
    public function lg(): static
    {
        return $this->size('lg');
    }

    /**
     * Enable vertical orientation
     *
     * @param bool $vertical
     * @return static
     */
    public function vertical(bool $vertical = true): static
    {
        $this->vertical = $vertical;
        return $this;
    }

    /**
     * Set value suffix
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
     * Set value prefix
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
     * Set external output element selector
     *
     * @param string $selector CSS selector for external value display
     * @return static
     */
    public function output(string $selector): static
    {
        $this->output = $selector;
        return $this;
    }

    /**
     * Set separator for range slider output
     *
     * @param string $separator
     * @return static
     */
    public function separator(string $separator): static
    {
        $this->separator = $separator;
        return $this;
    }

    /**
     * Build wrapper CSS classes
     *
     * @return string
     */
    protected function buildWrapperClasses(): string
    {
        $classes = [CssPrefix::cls('slider')];

        // Size variant
        if ($this->size) {
            $classes[] = CssPrefix::cls('slider', $this->size);
        }

        // Color variant
        $classes[] = CssPrefix::cls('slider', $this->variant);

        // Discrete (tick marks)
        if ($this->tickCount > 0) {
            $classes[] = CssPrefix::cls('slider-discrete');
        }

        // Labeled (tooltip)
        if ($this->showTooltip) {
            $classes[] = CssPrefix::cls('slider-labeled');
        }

        // Vertical
        if ($this->vertical) {
            $classes[] = CssPrefix::cls('slider-vertical');
        }

        // Range slider
        if ($this->isRangeSlider) {
            $classes[] = CssPrefix::cls('slider-range');
        }

        // Disabled
        if ($this->disabled) {
            $classes[] = CssPrefix::cls('disabled');
        }

        // Add user-defined classes
        if (!empty($this->classes)) {
            $classes = array_merge($classes, $this->classes);
        }

        return implode(' ', array_unique($classes));
    }

    /**
     * Build data attributes for the wrapper
     *
     * @return array<string, mixed>
     */
    protected function buildWrapperDataAttributes(): array
    {
        $attrs = [];

        // Main initialization attribute
        if ($this->isRangeSlider) {
            $attrs[CssPrefix::data('slider-range')] = true;
        } else {
            $attrs[CssPrefix::data('slider')] = true;
        }

        // Optional data attributes
        if ($this->output !== null) {
            $attrs[CssPrefix::data('output')] = $this->output;
        }

        if ($this->prefix !== null) {
            $attrs[CssPrefix::data('prefix')] = $this->prefix;
        }

        if ($this->suffix !== null) {
            $attrs[CssPrefix::data('suffix')] = $this->suffix;
        }

        if ($this->tickCount > 0) {
            $attrs[CssPrefix::data('ticks')] = $this->tickCount;
        }

        if ($this->isRangeSlider && $this->separator !== ' - ') {
            $attrs[CssPrefix::data('separator')] = $this->separator;
        }

        // Merge user-defined data attributes
        foreach ($this->dataAttributes as $key => $value) {
            $attrs[CssPrefix::data($key)] = $value;
        }

        return $attrs;
    }

    /**
     * Render the complete slider element
     *
     * Generates:
     * <div class="so-slider so-slider-primary" data-so-slider>
     *     <input type="range" class="so-slider-input" ...>
     *     <div class="so-slider-track">
     *         <div class="so-slider-fill"></div>
     *         <div class="so-slider-thumb">
     *             <span class="so-slider-tooltip">value</span> <!-- if showTooltip -->
     *         </div>
     *     </div>
     * </div>
     *
     * @return string
     */
    public function render(): string
    {
        // Build wrapper opening tag
        $html = '<div';

        // ID on wrapper
        if ($this->id) {
            $html .= ' id="' . e($this->id) . '"';
        }

        // Classes
        $html .= ' class="' . $this->buildWrapperClasses() . '"';

        // Data attributes
        foreach ($this->buildWrapperDataAttributes() as $attr => $value) {
            if ($value === true) {
                $html .= ' ' . e($attr);
            } elseif ($value !== false && $value !== null) {
                $html .= ' ' . e($attr) . '="' . e($value) . '"';
            }
        }

        $html .= '>';

        // Render input(s)
        if ($this->isRangeSlider) {
            $html .= $this->renderRangeInputs();
        } else {
            $html .= $this->renderSingleInput();
        }

        // Render track structure
        $html .= $this->renderTrack();

        $html .= '</div>';

        return $html;
    }

    /**
     * Render single range input
     *
     * @return string
     */
    protected function renderSingleInput(): string
    {
        $attrs = [
            'type' => 'range',
            'class' => CssPrefix::cls('slider-input'),
            'min' => $this->min,
            'max' => $this->max,
            'value' => $this->value ?? $this->min,
        ];

        if ($this->step !== 1) {
            $attrs['step'] = $this->step;
        }

        if ($this->name) {
            $attrs['name'] = $this->name;
        }

        if ($this->disabled) {
            $attrs['disabled'] = true;
        }

        return $this->buildInputTag($attrs);
    }

    /**
     * Render dual range inputs for range slider
     *
     * @return string
     */
    protected function renderRangeInputs(): string
    {
        $html = '';

        // Min input
        $minAttrs = [
            'type' => 'range',
            'class' => CssPrefix::cls('slider-input') . ' ' . CssPrefix::cls('slider-input-min'),
            'min' => $this->min,
            'max' => $this->max,
            'value' => $this->value ?? $this->min,
        ];

        if ($this->step !== 1) {
            $minAttrs['step'] = $this->step;
        }

        if ($this->name) {
            $minAttrs['name'] = $this->name;
        }

        if ($this->disabled) {
            $minAttrs['disabled'] = true;
        }

        $html .= $this->buildInputTag($minAttrs);

        // Max input
        $maxAttrs = [
            'type' => 'range',
            'class' => CssPrefix::cls('slider-input') . ' ' . CssPrefix::cls('slider-input-max'),
            'min' => $this->min,
            'max' => $this->max,
            'value' => $this->valueEnd ?? $this->max,
        ];

        if ($this->step !== 1) {
            $maxAttrs['step'] = $this->step;
        }

        if ($this->name) {
            $maxAttrs['name'] = $this->name . '_end';
        }

        if ($this->disabled) {
            $maxAttrs['disabled'] = true;
        }

        $html .= $this->buildInputTag($maxAttrs);

        return $html;
    }

    /**
     * Build an input tag from attributes
     *
     * @param array $attrs
     * @return string
     */
    protected function buildInputTag(array $attrs): string
    {
        $html = '<input';

        foreach ($attrs as $name => $value) {
            if ($value === true) {
                $html .= ' ' . e($name);
            } elseif ($value !== false && $value !== null) {
                $html .= ' ' . e($name) . '="' . e($value) . '"';
            }
        }

        $html .= '>';

        return $html;
    }

    /**
     * Render the track structure
     *
     * @return string
     */
    protected function renderTrack(): string
    {
        $html = '<div class="' . CssPrefix::cls('slider-track') . '">';
        $html .= '<div class="' . CssPrefix::cls('slider-fill') . '"></div>';

        if ($this->isRangeSlider) {
            // Two thumbs for range slider
            $html .= '<div class="' . CssPrefix::cls('slider-thumb') . ' ' . CssPrefix::cls('slider-thumb-min') . '"></div>';
            $html .= '<div class="' . CssPrefix::cls('slider-thumb') . ' ' . CssPrefix::cls('slider-thumb-max') . '"></div>';
        } else {
            // Single thumb
            $html .= '<div class="' . CssPrefix::cls('slider-thumb') . '">';

            // Tooltip inside thumb if enabled
            if ($this->showTooltip) {
                $tooltipValue = $this->value ?? $this->min;
                $html .= '<span class="' . CssPrefix::cls('slider-tooltip') . '">' . e($tooltipValue) . '</span>';
            }

            $html .= '</div>';
        }

        // Tick marks container for discrete slider
        if ($this->tickCount > 0) {
            $html .= '<div class="' . CssPrefix::cls('slider-ticks') . '"></div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Convert to array configuration
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->min !== 0) {
            $config['min'] = $this->min;
        }

        if ($this->max !== 100) {
            $config['max'] = $this->max;
        }

        if ($this->step !== 1) {
            $config['step'] = $this->step;
        }

        if ($this->isRangeSlider) {
            $config['range'] = true;
        }

        if ($this->valueEnd !== null) {
            $config['valueEnd'] = $this->valueEnd;
        }

        if ($this->showTooltip) {
            $config['showTooltip'] = true;
        }

        if ($this->tickCount > 0) {
            $config['ticks'] = $this->tickCount;
        }

        if ($this->variant !== 'primary') {
            $config['variant'] = $this->variant;
        }

        if ($this->size !== null) {
            $config['size'] = $this->size;
        }

        if ($this->vertical) {
            $config['vertical'] = true;
        }

        if ($this->suffix !== null) {
            $config['suffix'] = $this->suffix;
        }

        if ($this->prefix !== null) {
            $config['prefix'] = $this->prefix;
        }

        if ($this->output !== null) {
            $config['output'] = $this->output;
        }

        if ($this->separator !== ' - ') {
            $config['separator'] = $this->separator;
        }

        return $config;
    }
}
