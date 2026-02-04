<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * OtpInput - One-Time Password input
 *
 * Provides a segmented input for OTP/PIN codes
 */
class OtpInput extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'otp-input';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Number of digits
     *
     * @var int
     */
    protected int $length = 6;

    /**
     * Input type (number, text, password)
     *
     * @var string
     */
    protected string $inputType = 'text';

    /**
     * Mask input (show dots)
     *
     * @var bool
     */
    protected bool $masked = false;

    /**
     * Auto-submit when complete
     *
     * @var bool
     */
    protected bool $autoSubmit = false;

    /**
     * Auto-focus first input
     *
     * @var bool
     */
    protected bool $autoFocus = true;

    /**
     * Allow paste
     *
     * @var bool
     */
    protected bool $allowPaste = true;

    /**
     * Group separator (e.g., show as XXX-XXX)
     *
     * @var int|null
     */
    protected ?int $groupSize = null;

    /**
     * Input variant
     *
     * @var string
     */
    protected string $variant = 'default';

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['length'])) {
            $this->length = (int) $config['length'];
        }

        if (isset($config['inputType'])) {
            $this->inputType = $config['inputType'];
        }

        if (isset($config['masked'])) {
            $this->masked = (bool) $config['masked'];
        }

        if (isset($config['autoSubmit'])) {
            $this->autoSubmit = (bool) $config['autoSubmit'];
        }

        if (isset($config['autoFocus'])) {
            $this->autoFocus = (bool) $config['autoFocus'];
        }

        if (isset($config['allowPaste'])) {
            $this->allowPaste = (bool) $config['allowPaste'];
        }

        if (isset($config['groupSize'])) {
            $this->groupSize = (int) $config['groupSize'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }
    }

    /**
     * Set number of digits
     *
     * @param int $length
     * @return static
     */
    public function length(int $length): static
    {
        $this->length = $length;
        return $this;
    }

    /**
     * Set 4 digit code
     *
     * @return static
     */
    public function pin4(): static
    {
        return $this->length(4);
    }

    /**
     * Set 6 digit code
     *
     * @return static
     */
    public function pin6(): static
    {
        return $this->length(6);
    }

    /**
     * Set input type
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
     * Numbers only
     *
     * @return static
     */
    public function numeric(): static
    {
        return $this->inputType('number');
    }

    /**
     * Alphanumeric
     *
     * @return static
     */
    public function alphanumeric(): static
    {
        return $this->inputType('text');
    }

    /**
     * Mask input
     *
     * @param bool $masked
     * @return static
     */
    public function masked(bool $masked = true): static
    {
        $this->masked = $masked;
        return $this;
    }

    /**
     * Show as password
     *
     * @return static
     */
    public function password(): static
    {
        $this->inputType = 'password';
        return $this->masked(true);
    }

    /**
     * Auto-submit on complete
     *
     * @param bool $autoSubmit
     * @return static
     */
    public function autoSubmit(bool $autoSubmit = true): static
    {
        $this->autoSubmit = $autoSubmit;
        return $this;
    }

    /**
     * Auto-focus first input
     *
     * @param bool $autoFocus
     * @return static
     */
    public function autoFocus(bool $autoFocus = true): static
    {
        $this->autoFocus = $autoFocus;
        return $this;
    }

    /**
     * Allow paste
     *
     * @param bool $allowPaste
     * @return static
     */
    public function allowPaste(bool $allowPaste = true): static
    {
        $this->allowPaste = $allowPaste;
        return $this;
    }

    /**
     * Set group size for visual separation
     *
     * @param int $size
     * @return static
     */
    public function groupSize(int $size): static
    {
        $this->groupSize = $size;
        return $this;
    }

    /**
     * Group as XXX-XXX
     *
     * @return static
     */
    public function grouped(): static
    {
        return $this->groupSize(3);
    }

    /**
     * Set variant
     *
     * @param string $variant
     * @return static
     */
    public function variant(string $variant): static
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * Outline variant
     *
     * @return static
     */
    public function outline(): static
    {
        return $this->variant('outline');
    }

    /**
     * Filled variant
     *
     * @return static
     */
    public function filled(): static
    {
        return $this->variant('filled');
    }

    /**
     * Underline variant
     *
     * @return static
     */
    public function underline(): static
    {
        return $this->variant('underline');
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('otp-group'));
        $this->addClass(CssPrefix::cls('otp-group', $this->variant));

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

        $attrs[CssPrefix::data('ui-init')] = 'otp-input';

        // Store config for JS initialization
        $config = [
            'length' => $this->length,
            'inputType' => $this->inputType,
            'masked' => $this->masked,
            'autoSubmit' => $this->autoSubmit,
            'autoFocus' => $this->autoFocus,
            'allowPaste' => $this->allowPaste,
        ];

        if ($this->groupSize !== null) {
            $config['groupSize'] = $this->groupSize;
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
        $html = '<div';

        // Build attributes
        $attrs = $this->gatherAllAttributes();
        $attrs['class'] = $this->buildClassString();

        foreach ($attrs as $name => $value) {
            if ($value === true) {
                $html .= ' ' . e($name);
            } elseif ($value !== false && $value !== null) {
                $html .= ' ' . e($name) . '="' . e($value) . '"';
            }
        }

        $html .= '>';

        // Hidden field for the complete value
        $html .= '<input type="hidden" class="' . CssPrefix::cls('otp-value') . '"';
        if ($this->name !== null) {
            $html .= ' name="' . e($this->name) . '"';
        }
        if ($this->value !== null) {
            $html .= ' value="' . e($this->value) . '"';
        }
        $html .= '>';

        // Individual inputs
        $html .= '<div class="' . CssPrefix::cls('otp-inputs') . '">';

        $currentValue = $this->value ?? '';

        for ($i = 0; $i < $this->length; $i++) {
            // Add separator if grouping
            if ($this->groupSize !== null && $i > 0 && $i % $this->groupSize === 0) {
                $html .= '<span class="' . CssPrefix::cls('otp-separator') . '">-</span>';
            }

            $digitValue = isset($currentValue[$i]) ? $currentValue[$i] : '';

            $html .= '<input type="' . ($this->masked ? 'password' : ($this->inputType === 'number' ? 'tel' : 'text')) . '"';
            $html .= ' class="' . CssPrefix::cls('otp-input') . '"';
            $html .= ' maxlength="1"';
            $html .= ' autocomplete="one-time-code"';
            $html .= ' inputmode="' . ($this->inputType === 'number' ? 'numeric' : 'text') . '"';
            $html .= ' pattern="' . ($this->inputType === 'number' ? '[0-9]' : '[a-zA-Z0-9]') . '"';
            $html .= ' ' . CssPrefix::data('index') . '="' . $i . '"';

            if ($digitValue) {
                $html .= ' value="' . e($digitValue) . '"';
            }

            if ($i === 0 && $this->autoFocus) {
                $html .= ' autofocus';
            }

            if ($this->disabled) {
                $html .= ' disabled';
            }

            if ($this->readonly) {
                $html .= ' readonly';
            }

            $html .= '>';
        }

        $html .= '</div>';
        $html .= '</div>';

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

        if ($this->length !== 6) {
            $config['length'] = $this->length;
        }

        if ($this->inputType !== 'text') {
            $config['inputType'] = $this->inputType;
        }

        if ($this->masked) {
            $config['masked'] = true;
        }

        if ($this->autoSubmit) {
            $config['autoSubmit'] = true;
        }

        if (!$this->autoFocus) {
            $config['autoFocus'] = false;
        }

        if (!$this->allowPaste) {
            $config['allowPaste'] = false;
        }

        if ($this->groupSize !== null) {
            $config['groupSize'] = $this->groupSize;
        }

        if ($this->variant !== 'default') {
            $config['variant'] = $this->variant;
        }

        return $config;
    }
}
