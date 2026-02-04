<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * TimePicker - Time selection input
 *
 * Provides a time picker with customizable options
 */
class TimePicker extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'time-picker';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'input';

    /**
     * Time format (12 or 24 hour)
     *
     * @var int
     */
    protected int $hourFormat = 24;

    /**
     * Minute step
     *
     * @var int
     */
    protected int $minuteStep = 5;

    /**
     * Show seconds
     *
     * @var bool
     */
    protected bool $showSeconds = false;

    /**
     * Minimum time
     *
     * @var string|null
     */
    protected ?string $minTime = null;

    /**
     * Maximum time
     *
     * @var string|null
     */
    protected ?string $maxTime = null;

    /**
     * Show clear button
     *
     * @var bool
     */
    protected bool $clearable = true;

    /**
     * Show now button
     *
     * @var bool
     */
    protected bool $nowButton = true;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['hourFormat'])) {
            $this->hourFormat = (int) $config['hourFormat'];
        }

        if (isset($config['minuteStep'])) {
            $this->minuteStep = (int) $config['minuteStep'];
        }

        if (isset($config['showSeconds'])) {
            $this->showSeconds = (bool) $config['showSeconds'];
        }

        if (isset($config['minTime'])) {
            $this->minTime = $config['minTime'];
        }

        if (isset($config['maxTime'])) {
            $this->maxTime = $config['maxTime'];
        }

        if (isset($config['clearable'])) {
            $this->clearable = (bool) $config['clearable'];
        }

        if (isset($config['nowButton'])) {
            $this->nowButton = (bool) $config['nowButton'];
        }
    }

    /**
     * Set hour format (12 or 24)
     *
     * @param int $format
     * @return static
     */
    public function hourFormat(int $format): static
    {
        $this->hourFormat = $format;
        return $this;
    }

    /**
     * Use 12-hour format
     *
     * @return static
     */
    public function hour12(): static
    {
        return $this->hourFormat(12);
    }

    /**
     * Use 24-hour format
     *
     * @return static
     */
    public function hour24(): static
    {
        return $this->hourFormat(24);
    }

    /**
     * Set minute step
     *
     * @param int $step
     * @return static
     */
    public function minuteStep(int $step): static
    {
        $this->minuteStep = $step;
        return $this;
    }

    /**
     * Show seconds selector
     *
     * @param bool $show
     * @return static
     */
    public function showSeconds(bool $show = true): static
    {
        $this->showSeconds = $show;
        return $this;
    }

    /**
     * Set minimum time
     *
     * @param string $time
     * @return static
     */
    public function minTime(string $time): static
    {
        $this->minTime = $time;
        return $this;
    }

    /**
     * Set maximum time
     *
     * @param string $time
     * @return static
     */
    public function maxTime(string $time): static
    {
        $this->maxTime = $time;
        return $this;
    }

    /**
     * Set time range
     *
     * @param string $minTime
     * @param string $maxTime
     * @return static
     */
    public function timeRange(string $minTime, string $maxTime): static
    {
        $this->minTime = $minTime;
        $this->maxTime = $maxTime;
        return $this;
    }

    /**
     * Set business hours (9:00 - 17:00)
     *
     * @return static
     */
    public function businessHours(): static
    {
        return $this->timeRange('09:00', '17:00');
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
     * Show/hide now button
     *
     * @param bool $show
     * @return static
     */
    public function nowButton(bool $show = true): static
    {
        $this->nowButton = $show;
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
        $this->addClass(CssPrefix::cls('timepicker-input'));

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

        $attrs['type'] = 'text';
        $attrs['autocomplete'] = 'off';
        $attrs[CssPrefix::data('ui-init')] = 'time-picker';

        // Store config for JS initialization
        $config = [
            'hourFormat' => $this->hourFormat,
            'minuteStep' => $this->minuteStep,
            'showSeconds' => $this->showSeconds,
            'clearable' => $this->clearable,
            'nowButton' => $this->nowButton,
        ];

        if ($this->minTime !== null) {
            $config['minTime'] = $this->minTime;
        }

        if ($this->maxTime !== null) {
            $config['maxTime'] = $this->maxTime;
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
        $html = '<div class="' . CssPrefix::cls('timepicker-wrapper') . '">';
        $html .= '<div class="' . CssPrefix::cls('input-group') . '">';

        // Clock icon
        $html .= '<span class="' . CssPrefix::cls('input-group-text') . '">';
        $html .= '<span class="material-icons">schedule</span>';
        $html .= '</span>';

        // Input
        $html .= parent::render();

        // Clear button
        if ($this->clearable) {
            $html .= '<button type="button" class="' . CssPrefix::cls('btn') . ' ' . CssPrefix::cls('btn-outline-secondary') . ' ' . CssPrefix::cls('timepicker-clear') . '" aria-label="Clear">';
            $html .= '<span class="material-icons">close</span>';
            $html .= '</button>';
        }

        $html .= '</div>';

        // Time dropdown container
        $html .= '<div class="' . CssPrefix::cls('timepicker-dropdown') . '"></div>';

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

        if ($this->hourFormat !== 24) {
            $config['hourFormat'] = $this->hourFormat;
        }

        if ($this->minuteStep !== 5) {
            $config['minuteStep'] = $this->minuteStep;
        }

        if ($this->showSeconds) {
            $config['showSeconds'] = true;
        }

        if ($this->minTime !== null) {
            $config['minTime'] = $this->minTime;
        }

        if ($this->maxTime !== null) {
            $config['maxTime'] = $this->maxTime;
        }

        if (!$this->clearable) {
            $config['clearable'] = false;
        }

        if (!$this->nowButton) {
            $config['nowButton'] = false;
        }

        return $config;
    }
}
