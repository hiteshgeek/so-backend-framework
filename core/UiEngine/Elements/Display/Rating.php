<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Rating - Star rating display/input
 *
 * Displays a star rating, optionally interactive
 */
class Rating extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'rating';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Current value
     *
     * @var float
     */
    protected float $value = 0;

    /**
     * Maximum rating
     *
     * @var int
     */
    protected int $max = 5;

    /**
     * Allow half stars
     *
     * @var bool
     */
    protected bool $half = false;

    /**
     * Interactive (input) mode
     *
     * @var bool
     */
    protected bool $interactive = false;

    /**
     * Read-only mode
     *
     * @var bool
     */
    protected bool $readonly = false;

    /**
     * Rating size
     *
     * @var string|null
     */
    protected ?string $ratingSize = null;

    /**
     * Rating color
     *
     * @var string
     */
    protected string $color = 'warning';

    /**
     * Show value text
     *
     * @var bool
     */
    protected bool $showValue = false;

    /**
     * Custom icon (filled)
     *
     * @var string
     */
    protected string $iconFilled = 'star';

    /**
     * Custom icon (empty)
     *
     * @var string
     */
    protected string $iconEmpty = 'star_border';

    /**
     * Custom icon (half)
     *
     * @var string
     */
    protected string $iconHalf = 'star_half';

    /**
     * Field name for form submission
     *
     * @var string|null
     */
    protected ?string $name = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['value'])) {
            $this->value = (float) $config['value'];
        }

        if (isset($config['max'])) {
            $this->max = (int) $config['max'];
        }

        if (isset($config['half'])) {
            $this->half = (bool) $config['half'];
        }

        if (isset($config['interactive'])) {
            $this->interactive = (bool) $config['interactive'];
        }

        if (isset($config['readonly'])) {
            $this->readonly = (bool) $config['readonly'];
        }

        if (isset($config['size'])) {
            $this->ratingSize = $config['size'];
        }

        if (isset($config['color'])) {
            $this->color = $config['color'];
        }

        if (isset($config['showValue'])) {
            $this->showValue = (bool) $config['showValue'];
        }

        if (isset($config['iconFilled'])) {
            $this->iconFilled = $config['iconFilled'];
        }

        if (isset($config['iconEmpty'])) {
            $this->iconEmpty = $config['iconEmpty'];
        }

        if (isset($config['iconHalf'])) {
            $this->iconHalf = $config['iconHalf'];
        }

        if (isset($config['name'])) {
            $this->name = $config['name'];
        }
    }

    /**
     * Set value
     *
     * @param float $value
     * @return static
     */
    public function value(float $value): static
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Set maximum
     *
     * @param int $max
     * @return static
     */
    public function max(int $max): static
    {
        $this->max = $max;
        return $this;
    }

    /**
     * Allow half stars
     *
     * @param bool $half
     * @return static
     */
    public function half(bool $half = true): static
    {
        $this->half = $half;
        return $this;
    }

    /**
     * Enable interactive mode
     *
     * @param bool $interactive
     * @return static
     */
    public function interactive(bool $interactive = true): static
    {
        $this->interactive = $interactive;
        return $this;
    }

    /**
     * Set read-only
     *
     * @param bool $readonly
     * @return static
     */
    public function readonly(bool $readonly = true): static
    {
        $this->readonly = $readonly;
        return $this;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return static
     */
    public function size(string $size): static
    {
        $this->ratingSize = $size;
        return $this;
    }

    /**
     * Small size
     *
     * @return static
     */
    public function small(): static
    {
        return $this->size('sm');
    }

    /**
     * Large size
     *
     * @return static
     */
    public function large(): static
    {
        return $this->size('lg');
    }

    /**
     * Set color
     *
     * @param string $color
     * @return static
     */
    public function color(string $color): static
    {
        $this->color = $color;
        return $this;
    }

    /**
     * Show value text
     *
     * @param bool $show
     * @return static
     */
    public function showValue(bool $show = true): static
    {
        $this->showValue = $show;
        return $this;
    }

    /**
     * Set custom icons
     *
     * @param string $filled
     * @param string $empty
     * @param string|null $half
     * @return static
     */
    public function icons(string $filled, string $empty, ?string $half = null): static
    {
        $this->iconFilled = $filled;
        $this->iconEmpty = $empty;
        if ($half !== null) {
            $this->iconHalf = $half;
        }
        return $this;
    }

    /**
     * Set name for form
     *
     * @param string $name
     * @return static
     */
    public function name(string $name): static
    {
        $this->name = $name;
        $this->interactive = true;
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('rating'));

        if ($this->interactive && !$this->readonly) {
            $this->addClass(CssPrefix::cls('rating-interactive'));
        }

        if ($this->ratingSize !== null) {
            $this->addClass(CssPrefix::cls('rating', $this->ratingSize));
        }

        $this->addClass(CssPrefix::cls('text', $this->color));

        return parent::buildClassString();
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        if ($this->interactive) {
            $attrs[CssPrefix::data('ui-init')] = 'rating';
            $config = [
                'value' => $this->value,
                'max' => $this->max,
                'half' => $this->half,
                'readonly' => $this->readonly,
            ];
            $attrs[CssPrefix::data('ui-config')] = htmlspecialchars(json_encode($config), ENT_QUOTES);
        }

        return $attrs;
    }

    /**
     * Render content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Hidden input for form submission
        if ($this->interactive && $this->name !== null) {
            $html .= '<input type="hidden" name="' . e($this->name) . '" value="' . $this->value . '" class="' . CssPrefix::cls('rating-value') . '">';
        }

        // Stars container
        $html .= '<div class="' . CssPrefix::cls('rating-stars') . '">';

        for ($i = 1; $i <= $this->max; $i++) {
            $icon = $this->iconEmpty;

            if ($i <= floor($this->value)) {
                $icon = $this->iconFilled;
            } elseif ($this->half && $i - 0.5 <= $this->value) {
                $icon = $this->iconHalf;
            }

            $starClass = CssPrefix::cls('rating-star');

            if ($this->interactive && !$this->readonly) {
                $html .= '<button type="button" class="' . $starClass . '" ' . CssPrefix::data('value') . '="' . $i . '">';
                $html .= '<span class="material-icons">' . e($icon) . '</span>';
                $html .= '</button>';
            } else {
                $html .= '<span class="' . $starClass . '">';
                $html .= '<span class="material-icons">' . e($icon) . '</span>';
                $html .= '</span>';
            }
        }

        $html .= '</div>';

        // Value text
        if ($this->showValue) {
            $html .= '<span class="' . CssPrefix::cls('rating-text') . '">';
            $html .= number_format($this->value, $this->half ? 1 : 0) . ' / ' . $this->max;
            $html .= '</span>';
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

        $config['value'] = $this->value;

        if ($this->max !== 5) {
            $config['max'] = $this->max;
        }

        if ($this->half) {
            $config['half'] = true;
        }

        if ($this->interactive) {
            $config['interactive'] = true;
        }

        if ($this->readonly) {
            $config['readonly'] = true;
        }

        if ($this->ratingSize !== null) {
            $config['size'] = $this->ratingSize;
        }

        if ($this->color !== 'warning') {
            $config['color'] = $this->color;
        }

        if ($this->showValue) {
            $config['showValue'] = true;
        }

        if ($this->iconFilled !== 'star') {
            $config['iconFilled'] = $this->iconFilled;
        }

        if ($this->iconEmpty !== 'star_border') {
            $config['iconEmpty'] = $this->iconEmpty;
        }

        if ($this->iconHalf !== 'star_half') {
            $config['iconHalf'] = $this->iconHalf;
        }

        if ($this->name !== null) {
            $config['name'] = $this->name;
        }

        return $config;
    }
}
