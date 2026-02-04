<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * ColorInput - Color picker input
 *
 * Provides a color picker with preview and optional preset colors
 */
class ColorInput extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'color-input';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'input';

    /**
     * Preset color swatches
     *
     * @var array
     */
    protected array $presets = [];

    /**
     * Show text input alongside picker
     *
     * @var bool
     */
    protected bool $showInput = true;

    /**
     * Color format: hex, rgb, hsl
     *
     * @var string
     */
    protected string $format = 'hex';

    /**
     * Allow alpha/opacity
     *
     * @var bool
     */
    protected bool $alpha = false;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['presets'])) {
            $this->presets = $config['presets'];
        }

        if (isset($config['showInput'])) {
            $this->showInput = (bool) $config['showInput'];
        }

        if (isset($config['format'])) {
            $this->format = $config['format'];
        }

        if (isset($config['alpha'])) {
            $this->alpha = (bool) $config['alpha'];
        }
    }

    /**
     * Set preset colors
     *
     * @param array $presets
     * @return static
     */
    public function presets(array $presets): static
    {
        $this->presets = $presets;
        return $this;
    }

    /**
     * Add preset color
     *
     * @param string $color
     * @return static
     */
    public function addPreset(string $color): static
    {
        $this->presets[] = $color;
        return $this;
    }

    /**
     * Use default Bootstrap color presets
     *
     * @return static
     */
    public function bootstrapPresets(): static
    {
        $this->presets = [
            '#0d6efd', '#6610f2', '#6f42c1', '#d63384',
            '#dc3545', '#fd7e14', '#ffc107', '#198754',
            '#20c997', '#0dcaf0', '#adb5bd', '#212529',
        ];
        return $this;
    }

    /**
     * Show/hide text input
     *
     * @param bool $show
     * @return static
     */
    public function showInput(bool $show = true): static
    {
        $this->showInput = $show;
        return $this;
    }

    /**
     * Hide text input
     *
     * @return static
     */
    public function hideInput(): static
    {
        return $this->showInput(false);
    }

    /**
     * Set color format
     *
     * @param string $format
     * @return static
     */
    public function format(string $format): static
    {
        $this->format = $format;
        return $this;
    }

    /**
     * Set hex format
     *
     * @return static
     */
    public function hex(): static
    {
        return $this->format('hex');
    }

    /**
     * Set RGB format
     *
     * @return static
     */
    public function rgb(): static
    {
        return $this->format('rgb');
    }

    /**
     * Set HSL format
     *
     * @return static
     */
    public function hsl(): static
    {
        return $this->format('hsl');
    }

    /**
     * Enable alpha channel
     *
     * @param bool $alpha
     * @return static
     */
    public function alpha(bool $alpha = true): static
    {
        $this->alpha = $alpha;
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('form-control'));
        $this->addClass(CssPrefix::cls('form-control-color'));

        if ($this->size) {
            $this->addClass(CssPrefix::cls('form-control', $this->size));
        }

        if ($this->error) {
            $this->addClass(CssPrefix::cls('is-invalid'));
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
        $attrs = parent::gatherAllAttributes();

        $attrs['type'] = 'color';
        $attrs[CssPrefix::data('ui-init')] = 'color-input';

        // Store config for JS initialization
        $config = [
            'showInput' => $this->showInput,
            'format' => $this->format,
            'alpha' => $this->alpha,
        ];

        if (!empty($this->presets)) {
            $config['presets'] = $this->presets;
        }

        $attrs[CssPrefix::data('ui-config')] = htmlspecialchars(json_encode($config), ENT_QUOTES);

        return $attrs;
    }

    /**
     * Render the complete element
     *
     * @return string
     */
    public function render(): string
    {
        $html = '<div class="' . CssPrefix::cls('color-input-wrapper') . '">';

        // Color picker
        $html .= parent::render();

        // Text input for manual entry
        if ($this->showInput) {
            $html .= '<input type="text" class="' . CssPrefix::cls('form-control') . ' ' . CssPrefix::cls('color-input-text') . '" ';
            $html .= 'value="' . e($this->value ?? '#000000') . '" ';
            $html .= 'pattern="^#[0-9A-Fa-f]{6}$">';
        }

        $html .= '</div>';

        // Preset swatches
        if (!empty($this->presets)) {
            $html .= '<div class="' . CssPrefix::cls('color-presets') . '">';
            foreach ($this->presets as $color) {
                $html .= '<button type="button" class="' . CssPrefix::cls('color-preset-btn') . '" ';
                $html .= 'style="background-color: ' . e($color) . '" ';
                $html .= CssPrefix::data('color') . '="' . e($color) . '" ';
                $html .= 'title="' . e($color) . '"></button>';
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

        if (!empty($this->presets)) {
            $config['presets'] = $this->presets;
        }

        if (!$this->showInput) {
            $config['showInput'] = false;
        }

        if ($this->format !== 'hex') {
            $config['format'] = $this->format;
        }

        if ($this->alpha) {
            $config['alpha'] = true;
        }

        return $config;
    }
}
