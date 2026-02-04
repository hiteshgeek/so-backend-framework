<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Progress - Progress indicator component
 *
 * Supports linear and circular progress with various styles and features
 */
class Progress extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'progress';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Progress type: linear, circular
     *
     * @var string
     */
    protected string $progressType = 'linear';

    /**
     * Current value
     *
     * @var int|float
     */
    protected int|float $value = 0;

    /**
     * Maximum value
     *
     * @var int|float
     */
    protected int|float $max = 100;

    /**
     * Minimum value
     *
     * @var int|float
     */
    protected int|float $min = 0;

    /**
     * Color variant
     *
     * @var string|null
     */
    protected ?string $color = null;

    /**
     * Size (xs, sm, lg, xl)
     *
     * @var string|null
     */
    protected ?string $size = null;

    /**
     * Show label inside bar
     *
     * @var bool
     */
    protected bool $showLabel = false;

    /**
     * Custom label text
     *
     * @var string|null
     */
    protected ?string $labelText = null;

    /**
     * Striped style
     *
     * @var bool
     */
    protected bool $striped = false;

    /**
     * Animated stripes
     *
     * @var bool
     */
    protected bool $animated = false;

    /**
     * Indeterminate mode
     *
     * @var bool
     */
    protected bool $indeterminate = false;

    /**
     * Buffer mode with buffer value
     *
     * @var float|null
     */
    protected ?float $bufferValue = null;

    /**
     * Gradient variant
     *
     * @var string|null
     */
    protected ?string $gradient = null;

    /**
     * Segments for stacked progress
     *
     * @var array
     */
    protected array $segments = [];

    /**
     * Steps for stepped progress
     *
     * @var array
     */
    protected array $steps = [];

    /**
     * External label wrapper
     *
     * @var array|null
     */
    protected ?array $externalLabel = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['progressType'])) {
            $this->progressType = $config['progressType'];
        }

        if (isset($config['value'])) {
            $this->value = $config['value'];
        }

        if (isset($config['max'])) {
            $this->max = $config['max'];
        }

        if (isset($config['min'])) {
            $this->min = $config['min'];
        }

        if (isset($config['color'])) {
            $this->color = $config['color'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        if (isset($config['showLabel'])) {
            $this->showLabel = (bool) $config['showLabel'];
        }

        if (isset($config['labelText'])) {
            $this->labelText = $config['labelText'];
        }

        if (isset($config['striped'])) {
            $this->striped = (bool) $config['striped'];
        }

        if (isset($config['animated'])) {
            $this->animated = (bool) $config['animated'];
        }

        if (isset($config['indeterminate'])) {
            $this->indeterminate = (bool) $config['indeterminate'];
        }

        if (isset($config['bufferValue'])) {
            $this->bufferValue = $config['bufferValue'];
        }

        if (isset($config['gradient'])) {
            $this->gradient = $config['gradient'];
        }

        if (isset($config['segments'])) {
            $this->segments = $config['segments'];
        }

        if (isset($config['steps'])) {
            $this->steps = $config['steps'];
        }

        if (isset($config['externalLabel'])) {
            $this->externalLabel = $config['externalLabel'];
        }
    }

    // Configuration methods
    public function linear(): static { $this->progressType = 'linear'; return $this; }
    public function circular(): static { $this->progressType = 'circular'; return $this; }

    public function value(int|float $value): static { $this->value = $value; return $this; }
    public function max(int|float $max): static { $this->max = $max; return $this; }
    public function min(int|float $min): static { $this->min = $min; return $this; }

    public function color(string $color): static { $this->color = $color; return $this; }
    public function primary(): static { return $this->color('primary'); }
    public function secondary(): static { return $this->color('secondary'); }
    public function success(): static { return $this->color('success'); }
    public function danger(): static { return $this->color('danger'); }
    public function warning(): static { return $this->color('warning'); }
    public function info(): static { return $this->color('info'); }
    public function light(): static { return $this->color('light'); }
    public function dark(): static { return $this->color('dark'); }

    public function size(string $size): static { $this->size = $size; return $this; }
    public function extraSmall(): static { return $this->size('xs'); }
    public function small(): static { return $this->size('sm'); }
    public function large(): static { return $this->size('lg'); }
    public function extraLarge(): static { return $this->size('xl'); }

    public function showLabel(bool $show = true, ?string $text = null): static
    {
        $this->showLabel = $show;
        if ($text !== null) $this->labelText = $text;
        return $this;
    }

    public function striped(bool $striped = true): static { $this->striped = $striped; return $this; }
    public function animated(bool $animated = true): static
    {
        $this->animated = $animated;
        if ($animated) $this->striped = true;
        return $this;
    }

    public function indeterminate(bool $indeterminate = true): static
    {
        $this->indeterminate = $indeterminate;
        return $this;
    }

    public function buffer(float $bufferValue): static
    {
        $this->bufferValue = $bufferValue;
        return $this;
    }

    public function gradient(?string $variant = null): static
    {
        $this->gradient = $variant ?? 'gradient';
        return $this;
    }

    public function segment(float $value, string $color, ?string $label = null): static
    {
        $this->segments[] = ['value' => $value, 'color' => $color, 'label' => $label];
        return $this;
    }

    public function step(bool $active = false, ?float $partial = null): static
    {
        $this->steps[] = ['active' => $active, 'partial' => $partial];
        return $this;
    }

    public function externalLabel(string $title, string $value): static
    {
        $this->externalLabel = ['title' => $title, 'value' => $value];
        return $this;
    }

    protected function calculatePercent(?float $value = null): float
    {
        $val = $value ?? $this->value;
        $range = $this->max - $this->min;
        return $range > 0 ? (($val - $this->min) / $range) * 100 : 0;
    }

    public function buildClassString(): string
    {
        if ($this->progressType === 'circular') {
            $this->addClass(CssPrefix::cls('progress-circular'));
            if ($this->size) $this->addClass(CssPrefix::cls('progress-circular', $this->size));
            if ($this->color) $this->addClass(CssPrefix::cls('progress-circular', $this->color));
            if ($this->indeterminate) $this->addClass(CssPrefix::cls('progress-circular-indeterminate'));
        } else {
            $this->addClass(CssPrefix::cls('progress'));
            if ($this->color) $this->addClass(CssPrefix::cls('progress', $this->color));
            if ($this->size) $this->addClass(CssPrefix::cls('progress', $this->size));
            if ($this->striped) $this->addClass(CssPrefix::cls('progress-striped'));
            if ($this->animated) $this->addClass(CssPrefix::cls('progress-animated'));
            if ($this->indeterminate) $this->addClass(CssPrefix::cls('progress-indeterminate'));
            if ($this->bufferValue !== null) $this->addClass(CssPrefix::cls('progress-buffer'));
            if (!empty($this->segments)) $this->addClass(CssPrefix::cls('progress-stacked'));
            if ($this->gradient) $this->addClass(CssPrefix::cls('progress', $this->gradient));
            if (!empty($this->steps)) $this->addClass(CssPrefix::cls('progress-stepped'));
        }
        return parent::buildClassString();
    }

    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();
        if ($this->progressType === 'linear' && !$this->indeterminate) {
            $attrs['role'] = 'progressbar';
            $attrs['aria-valuenow'] = $this->value;
            $attrs['aria-valuemin'] = $this->min;
            $attrs['aria-valuemax'] = $this->max;
        }
        return $attrs;
    }

    public function renderContent(): string
    {
        if ($this->progressType === 'circular') {
            return $this->renderCircular();
        }

        if (!empty($this->steps)) {
            return $this->renderStepped();
        }

        if (!empty($this->segments)) {
            return $this->renderStacked();
        }

        return $this->renderLinear();
    }

    protected function renderLinear(): string
    {
        $html = '<div class="' . CssPrefix::cls('progress-bar') . '" style="width: ' . $this->calculatePercent() . '%">';
        if ($this->showLabel) {
            $html .= '<span class="' . CssPrefix::cls('progress-label') . '">';
            $html .= e($this->labelText ?? round($this->calculatePercent()) . '%');
            $html .= '</span>';
        }
        $html .= '</div>';

        if ($this->bufferValue !== null) {
            $html .= '<div class="' . CssPrefix::cls('progress-buffer-bar') . '" style="width: ' . $this->calculatePercent($this->bufferValue) . '%"></div>';
        }

        return $html;
    }

    protected function renderStacked(): string
    {
        $html = '';
        foreach ($this->segments as $seg) {
            $html .= '<div class="' . CssPrefix::cls('progress') . ' ' . CssPrefix::cls('progress', $seg['color']) . '" style="width: ' . $seg['value'] . '%">';
            $html .= '<div class="' . CssPrefix::cls('progress-bar') . '" style="width: 100%">';
            if ($seg['label']) $html .= '<span class="' . CssPrefix::cls('progress-label') . '">' . e($seg['label']) . '</span>';
            $html .= '</div></div>';
        }
        return $html;
    }

    protected function renderStepped(): string
    {
        $html = '';
        foreach ($this->steps as $step) {
            $stepClass = CssPrefix::cls('progress-step');
            if ($step['active']) $stepClass .= ' ' . CssPrefix::cls('active');
            if ($step['partial']) $stepClass .= ' partial';

            $html .= '<div class="' . $stepClass . '"';
            if ($step['partial']) $html .= ' style="--step-progress: ' . $step['partial'] . '%"';
            $html .= '><div class="' . CssPrefix::cls('progress-step-fill') . '"></div></div>';
        }
        return $html;
    }

    protected function renderCircular(): string
    {
        $size = match($this->size) {
            'xs' => ['viewBox' => '0 0 32 32', 'cx' => 16, 'cy' => 16, 'r' => 13],
            'sm' => ['viewBox' => '0 0 40 40', 'cx' => 20, 'cy' => 20, 'r' => 17],
            'lg' => ['viewBox' => '0 0 64 64', 'cx' => 32, 'cy' => 32, 'r' => 27],
            'xl' => ['viewBox' => '0 0 80 80', 'cx' => 40, 'cy' => 40, 'r' => 34],
            default => ['viewBox' => '0 0 48 48', 'cx' => 24, 'cy' => 24, 'r' => 20]
        };

        $html = '<svg class="' . CssPrefix::cls('progress-ring') . '" viewBox="' . $size['viewBox'] . '">';
        $html .= '<circle class="' . CssPrefix::cls('progress-ring-bg') . '" cx="' . $size['cx'] . '" cy="' . $size['cy'] . '" r="' . $size['r'] . '" fill="none"></circle>';

        if (!$this->indeterminate) {
            $circumference = 2 * pi() * $size['r'];
            $offset = $circumference * (1 - $this->calculatePercent() / 100);
            $html .= '<circle class="' . CssPrefix::cls('progress-ring-fill') . '" cx="' . $size['cx'] . '" cy="' . $size['cy'] . '" r="' . $size['r'] . '" fill="none" stroke-dasharray="' . $circumference . '" stroke-dashoffset="' . $offset . '"></circle>';
        } else {
            $html .= '<circle class="' . CssPrefix::cls('progress-ring-fill') . '" cx="' . $size['cx'] . '" cy="' . $size['cy'] . '" r="' . $size['r'] . '" fill="none"></circle>';
        }

        $html .= '</svg>';

        if ($this->showLabel && !$this->indeterminate) {
            $html .= '<span class="' . CssPrefix::cls('progress-text') . '">' . e($this->labelText ?? round($this->calculatePercent()) . '%') . '</span>';
        }

        return $html;
    }

    public function render(): string
    {
        if ($this->externalLabel) {
            $wrapper = '<div class="' . CssPrefix::cls('progress-wrapper') . '">';
            $wrapper .= '<div class="' . CssPrefix::cls('progress-header') . '">';
            $wrapper .= '<span class="' . CssPrefix::cls('progress-title') . '">' . e($this->externalLabel['title']) . '</span>';
            $wrapper .= '<span class="' . CssPrefix::cls('progress-value') . '">' . e($this->externalLabel['value']) . '</span>';
            $wrapper .= '</div>';
            $wrapper .= parent::render();
            $wrapper .= '</div>';
            return $wrapper;
        }

        return parent::render();
    }

    public function toArray(): array
    {
        $config = parent::toArray();
        $config['progressType'] = $this->progressType;
        $config['value'] = $this->value;
        if ($this->max !== 100) $config['max'] = $this->max;
        if ($this->min !== 0) $config['min'] = $this->min;
        if ($this->color) $config['color'] = $this->color;
        if ($this->size) $config['size'] = $this->size;
        if ($this->showLabel) $config['showLabel'] = true;
        if ($this->labelText) $config['labelText'] = $this->labelText;
        if ($this->striped) $config['striped'] = true;
        if ($this->animated) $config['animated'] = true;
        if ($this->indeterminate) $config['indeterminate'] = true;
        if ($this->bufferValue !== null) $config['bufferValue'] = $this->bufferValue;
        if ($this->gradient) $config['gradient'] = $this->gradient;
        if (!empty($this->segments)) $config['segments'] = $this->segments;
        if (!empty($this->steps)) $config['steps'] = $this->steps;
        if ($this->externalLabel) $config['externalLabel'] = $this->externalLabel;
        return $config;
    }
}
