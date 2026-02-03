<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Tooltip - Hover tooltip
 *
 * Provides tooltip functionality for elements
 */
class Tooltip extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'tooltip';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'span';

    /**
     * Tooltip text
     *
     * @var string|null
     */
    protected ?string $text = null;

    /**
     * Tooltip placement
     *
     * @var string
     */
    protected string $placement = 'top';

    /**
     * Tooltip trigger
     *
     * @var string
     */
    protected string $trigger = 'hover focus';

    /**
     * Allow HTML in tooltip
     *
     * @var bool
     */
    protected bool $html = false;

    /**
     * Delay show/hide
     *
     * @var int
     */
    protected int $delay = 0;

    /**
     * Custom class for tooltip
     *
     * @var string|null
     */
    protected ?string $tooltipClass = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['text'])) {
            $this->text = $config['text'];
        }

        if (isset($config['placement'])) {
            $this->placement = $config['placement'];
        }

        if (isset($config['trigger'])) {
            $this->trigger = $config['trigger'];
        }

        if (isset($config['html'])) {
            $this->html = (bool) $config['html'];
        }

        if (isset($config['delay'])) {
            $this->delay = (int) $config['delay'];
        }

        if (isset($config['tooltipClass'])) {
            $this->tooltipClass = $config['tooltipClass'];
        }
    }

    /**
     * Set tooltip text
     *
     * @param string $text
     * @return static
     */
    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Set placement
     *
     * @param string $placement
     * @return static
     */
    public function placement(string $placement): static
    {
        $this->placement = $placement;
        return $this;
    }

    /**
     * Place on top
     *
     * @return static
     */
    public function top(): static
    {
        return $this->placement('top');
    }

    /**
     * Place on bottom
     *
     * @return static
     */
    public function bottom(): static
    {
        return $this->placement('bottom');
    }

    /**
     * Place on left
     *
     * @return static
     */
    public function left(): static
    {
        return $this->placement('left');
    }

    /**
     * Place on right
     *
     * @return static
     */
    public function right(): static
    {
        return $this->placement('right');
    }

    /**
     * Set trigger
     *
     * @param string $trigger
     * @return static
     */
    public function trigger(string $trigger): static
    {
        $this->trigger = $trigger;
        return $this;
    }

    /**
     * Trigger on hover only
     *
     * @return static
     */
    public function hoverOnly(): static
    {
        return $this->trigger('hover');
    }

    /**
     * Trigger on click
     *
     * @return static
     */
    public function clickTrigger(): static
    {
        return $this->trigger('click');
    }

    /**
     * Allow HTML content
     *
     * @param bool $html
     * @return static
     */
    public function html(bool $html = true): static
    {
        $this->html = $html;
        return $this;
    }

    /**
     * Set delay
     *
     * @param int $ms
     * @return static
     */
    public function delay(int $ms): static
    {
        $this->delay = $ms;
        return $this;
    }

    /**
     * Set custom tooltip class
     *
     * @param string $class
     * @return static
     */
    public function tooltipClass(string $class): static
    {
        $this->tooltipClass = $class;
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

        $attrs[CssPrefix::data('toggle')] = 'tooltip';
        $attrs[CssPrefix::data('placement')] = $this->placement;
        $attrs[CssPrefix::data('ui-init')] = 'tooltip';

        if ($this->text !== null) {
            $attrs['title'] = $this->text;
        }

        if ($this->html) {
            $attrs[CssPrefix::data('html')] = 'true';
        }

        if ($this->delay > 0) {
            $attrs[CssPrefix::data('delay')] = $this->delay;
        }

        if ($this->trigger !== 'hover focus') {
            $attrs[CssPrefix::data('trigger')] = $this->trigger;
        }

        if ($this->tooltipClass !== null) {
            $attrs[CssPrefix::data('custom-class')] = $this->tooltipClass;
        }

        $config = [
            'placement' => $this->placement,
            'trigger' => $this->trigger,
            'html' => $this->html,
            'delay' => $this->delay,
        ];
        $attrs[CssPrefix::data('ui-config')] = htmlspecialchars(json_encode($config), ENT_QUOTES);

        return $attrs;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->text !== null) {
            $config['text'] = $this->text;
        }

        if ($this->placement !== 'top') {
            $config['placement'] = $this->placement;
        }

        if ($this->trigger !== 'hover focus') {
            $config['trigger'] = $this->trigger;
        }

        if ($this->html) {
            $config['html'] = true;
        }

        if ($this->delay > 0) {
            $config['delay'] = $this->delay;
        }

        if ($this->tooltipClass !== null) {
            $config['tooltipClass'] = $this->tooltipClass;
        }

        return $config;
    }
}
