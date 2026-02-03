<?php

namespace Core\UiEngine\Elements\Form;

use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * DatePicker - Date selection input
 *
 * Provides a calendar-based date picker with customizable options
 */
class DatePicker extends FormElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'date-picker';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'input';

    /**
     * Date format for display
     *
     * @var string
     */
    protected string $format = 'Y-m-d';

    /**
     * Minimum selectable date
     *
     * @var string|null
     */
    protected ?string $minDate = null;

    /**
     * Maximum selectable date
     *
     * @var string|null
     */
    protected ?string $maxDate = null;

    /**
     * Disabled dates
     *
     * @var array
     */
    protected array $disabledDates = [];

    /**
     * Disabled days of week (0-6, Sunday=0)
     *
     * @var array
     */
    protected array $disabledDays = [];

    /**
     * Allow date range selection
     *
     * @var bool
     */
    protected bool $range = false;

    /**
     * Show week numbers
     *
     * @var bool
     */
    protected bool $weekNumbers = false;

    /**
     * Show clear button
     *
     * @var bool
     */
    protected bool $clearable = true;

    /**
     * Show today button
     *
     * @var bool
     */
    protected bool $todayButton = true;

    /**
     * First day of week (0=Sunday, 1=Monday)
     *
     * @var int
     */
    protected int $firstDayOfWeek = 1;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['format'])) {
            $this->format = $config['format'];
        }

        if (isset($config['minDate'])) {
            $this->minDate = $config['minDate'];
        }

        if (isset($config['maxDate'])) {
            $this->maxDate = $config['maxDate'];
        }

        if (isset($config['disabledDates'])) {
            $this->disabledDates = $config['disabledDates'];
        }

        if (isset($config['disabledDays'])) {
            $this->disabledDays = $config['disabledDays'];
        }

        if (isset($config['range'])) {
            $this->range = (bool) $config['range'];
        }

        if (isset($config['weekNumbers'])) {
            $this->weekNumbers = (bool) $config['weekNumbers'];
        }

        if (isset($config['clearable'])) {
            $this->clearable = (bool) $config['clearable'];
        }

        if (isset($config['todayButton'])) {
            $this->todayButton = (bool) $config['todayButton'];
        }

        if (isset($config['firstDayOfWeek'])) {
            $this->firstDayOfWeek = (int) $config['firstDayOfWeek'];
        }
    }

    /**
     * Set date format
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
     * Set minimum date
     *
     * @param string $date
     * @return static
     */
    public function minDate(string $date): static
    {
        $this->minDate = $date;
        return $this;
    }

    /**
     * Set maximum date
     *
     * @param string $date
     * @return static
     */
    public function maxDate(string $date): static
    {
        $this->maxDate = $date;
        return $this;
    }

    /**
     * Set date range
     *
     * @param string $minDate
     * @param string $maxDate
     * @return static
     */
    public function dateRange(string $minDate, string $maxDate): static
    {
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
        return $this;
    }

    /**
     * Disable specific dates
     *
     * @param array $dates
     * @return static
     */
    public function disabledDates(array $dates): static
    {
        $this->disabledDates = $dates;
        return $this;
    }

    /**
     * Disable days of week
     *
     * @param array $days
     * @return static
     */
    public function disabledDays(array $days): static
    {
        $this->disabledDays = $days;
        return $this;
    }

    /**
     * Disable weekends
     *
     * @return static
     */
    public function disableWeekends(): static
    {
        $this->disabledDays = [0, 6]; // Sunday and Saturday
        return $this;
    }

    /**
     * Enable range selection
     *
     * @param bool $range
     * @return static
     */
    public function range(bool $range = true): static
    {
        $this->range = $range;
        return $this;
    }

    /**
     * Show week numbers
     *
     * @param bool $show
     * @return static
     */
    public function weekNumbers(bool $show = true): static
    {
        $this->weekNumbers = $show;
        return $this;
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
     * Show/hide today button
     *
     * @param bool $show
     * @return static
     */
    public function todayButton(bool $show = true): static
    {
        $this->todayButton = $show;
        return $this;
    }

    /**
     * Set first day of week
     *
     * @param int $day
     * @return static
     */
    public function firstDayOfWeek(int $day): static
    {
        $this->firstDayOfWeek = $day;
        return $this;
    }

    /**
     * Start week on Sunday
     *
     * @return static
     */
    public function weekStartsSunday(): static
    {
        return $this->firstDayOfWeek(0);
    }

    /**
     * Start week on Monday
     *
     * @return static
     */
    public function weekStartsMonday(): static
    {
        return $this->firstDayOfWeek(1);
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('form-control'));
        $this->addClass(CssPrefix::cls('datepicker-input'));

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
        $attrs[CssPrefix::data('ui-init')] = 'date-picker';

        // Store config for JS initialization
        $config = [
            'format' => $this->format,
            'clearable' => $this->clearable,
            'todayButton' => $this->todayButton,
            'firstDayOfWeek' => $this->firstDayOfWeek,
            'range' => $this->range,
            'weekNumbers' => $this->weekNumbers,
        ];

        if ($this->minDate !== null) {
            $config['minDate'] = $this->minDate;
        }

        if ($this->maxDate !== null) {
            $config['maxDate'] = $this->maxDate;
        }

        if (!empty($this->disabledDates)) {
            $config['disabledDates'] = $this->disabledDates;
        }

        if (!empty($this->disabledDays)) {
            $config['disabledDays'] = $this->disabledDays;
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
        $html = '<div class="' . CssPrefix::cls('datepicker-wrapper') . '">';
        $html .= '<div class="' . CssPrefix::cls('input-group') . '">';

        // Calendar icon
        $html .= '<span class="' . CssPrefix::cls('input-group-text') . '">';
        $html .= '<span class="material-icons">calendar_today</span>';
        $html .= '</span>';

        // Input
        $html .= parent::render();

        // Clear button
        if ($this->clearable) {
            $html .= '<button type="button" class="' . CssPrefix::cls('btn') . ' ' . CssPrefix::cls('btn-outline-secondary') . ' ' . CssPrefix::cls('datepicker-clear') . '" aria-label="Clear">';
            $html .= '<span class="material-icons">close</span>';
            $html .= '</button>';
        }

        $html .= '</div>';

        // Calendar dropdown container
        $html .= '<div class="' . CssPrefix::cls('datepicker-dropdown') . '"></div>';

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

        if ($this->format !== 'Y-m-d') {
            $config['format'] = $this->format;
        }

        if ($this->minDate !== null) {
            $config['minDate'] = $this->minDate;
        }

        if ($this->maxDate !== null) {
            $config['maxDate'] = $this->maxDate;
        }

        if (!empty($this->disabledDates)) {
            $config['disabledDates'] = $this->disabledDates;
        }

        if (!empty($this->disabledDays)) {
            $config['disabledDays'] = $this->disabledDays;
        }

        if ($this->range) {
            $config['range'] = true;
        }

        if ($this->weekNumbers) {
            $config['weekNumbers'] = true;
        }

        if (!$this->clearable) {
            $config['clearable'] = false;
        }

        if (!$this->todayButton) {
            $config['todayButton'] = false;
        }

        if ($this->firstDayOfWeek !== 1) {
            $config['firstDayOfWeek'] = $this->firstDayOfWeek;
        }

        return $config;
    }
}
