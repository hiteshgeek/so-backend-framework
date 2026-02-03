<?php

namespace Core\UiEngine\Elements\Navigation;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Collapse - Collapsible content
 *
 * Provides toggle-able collapsible content
 */
class Collapse extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'collapse';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Content to collapse
     *
     * @var string|null
     */
    protected ?string $collapseContent = null;

    /**
     * Trigger text
     *
     * @var string|null
     */
    protected ?string $trigger = null;

    /**
     * Trigger variant
     *
     * @var string
     */
    protected string $triggerVariant = 'primary';

    /**
     * Initially expanded
     *
     * @var bool
     */
    protected bool $expanded = false;

    /**
     * Horizontal collapse
     *
     * @var bool
     */
    protected bool $horizontal = false;

    /**
     * Show trigger
     *
     * @var bool
     */
    protected bool $showTrigger = true;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['content'])) {
            $this->collapseContent = $config['content'];
        }

        if (isset($config['trigger'])) {
            $this->trigger = $config['trigger'];
        }

        if (isset($config['triggerVariant'])) {
            $this->triggerVariant = $config['triggerVariant'];
        }

        if (isset($config['expanded'])) {
            $this->expanded = (bool) $config['expanded'];
        }

        if (isset($config['horizontal'])) {
            $this->horizontal = (bool) $config['horizontal'];
        }

        if (isset($config['showTrigger'])) {
            $this->showTrigger = (bool) $config['showTrigger'];
        }
    }

    /**
     * Set content
     *
     * @param string $content
     * @return static
     */
    public function content(string $content): static
    {
        $this->collapseContent = $content;
        return $this;
    }

    /**
     * Set trigger text
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
     * Set trigger variant
     *
     * @param string $variant
     * @return static
     */
    public function triggerVariant(string $variant): static
    {
        $this->triggerVariant = $variant;
        return $this;
    }

    /**
     * Set expanded state
     *
     * @param bool $expanded
     * @return static
     */
    public function expanded(bool $expanded = true): static
    {
        $this->expanded = $expanded;
        return $this;
    }

    /**
     * Set collapsed (not expanded)
     *
     * @return static
     */
    public function collapsed(): static
    {
        return $this->expanded(false);
    }

    /**
     * Set horizontal collapse
     *
     * @param bool $horizontal
     * @return static
     */
    public function horizontal(bool $horizontal = true): static
    {
        $this->horizontal = $horizontal;
        return $this;
    }

    /**
     * Show/hide trigger
     *
     * @param bool $show
     * @return static
     */
    public function showTrigger(bool $show = true): static
    {
        $this->showTrigger = $show;
        return $this;
    }

    /**
     * Hide trigger (for external trigger control)
     *
     * @return static
     */
    public function hideTrigger(): static
    {
        return $this->showTrigger(false);
    }

    /**
     * Gather all attributes
     *
     * @return array<string, mixed>
     */
    protected function gatherAllAttributes(): array
    {
        $attrs = parent::gatherAllAttributes();

        $attrs[CssPrefix::data('ui-init')] = 'collapse';

        $config = [
            'expanded' => $this->expanded,
            'horizontal' => $this->horizontal,
        ];

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
        $collapseId = $this->id ?? 'collapse-' . uniqid();
        $html = '';

        // Trigger button
        if ($this->showTrigger && $this->trigger !== null) {
            $btnClass = CssPrefix::cls('btn') . ' ' . CssPrefix::cls('btn', $this->triggerVariant);

            $html .= '<button class="' . $btnClass . '" type="button"';
            $html .= ' ' . CssPrefix::data('toggle') . '="collapse"';
            $html .= ' ' . CssPrefix::data('target') . '="#' . $collapseId . '"';
            $html .= ' aria-expanded="' . ($this->expanded ? 'true' : 'false') . '"';
            $html .= ' aria-controls="' . $collapseId . '">';
            $html .= e($this->trigger);
            $html .= '</button>';
        }

        // Collapsible content
        $collapseClass = CssPrefix::cls('collapse');

        if ($this->horizontal) {
            $collapseClass .= ' ' . CssPrefix::cls('collapse-horizontal');
        }

        if ($this->expanded) {
            $collapseClass .= ' ' . CssPrefix::cls('show');
        }

        $html .= '<div class="' . $collapseClass . '" id="' . $collapseId . '"';

        // Add custom classes and data attributes
        $attrs = $this->gatherAllAttributes();
        unset($attrs['id']); // Already added

        foreach ($attrs as $name => $value) {
            if ($name === 'class') continue; // Handle separately
            if ($value === true) {
                $html .= ' ' . e($name);
            } elseif ($value !== false && $value !== null) {
                $html .= ' ' . e($name) . '="' . e($value) . '"';
            }
        }

        $html .= '>';

        // Inner wrapper for horizontal collapse
        if ($this->horizontal) {
            $html .= '<div class="' . CssPrefix::cls('collapse-horizontal-inner') . '">';
        }

        // Content
        if ($this->collapseContent !== null) {
            $html .= $this->collapseContent;
        }

        // Render children
        $html .= $this->renderChildren();

        if ($this->horizontal) {
            $html .= '</div>';
        }

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

        if ($this->collapseContent !== null) {
            $config['content'] = $this->collapseContent;
        }

        if ($this->trigger !== null) {
            $config['trigger'] = $this->trigger;
        }

        if ($this->triggerVariant !== 'primary') {
            $config['triggerVariant'] = $this->triggerVariant;
        }

        if ($this->expanded) {
            $config['expanded'] = true;
        }

        if ($this->horizontal) {
            $config['horizontal'] = true;
        }

        if (!$this->showTrigger) {
            $config['showTrigger'] = false;
        }

        return $config;
    }
}
