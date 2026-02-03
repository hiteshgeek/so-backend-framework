<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Stepper - Step wizard/progress
 *
 * Displays a multi-step process/wizard
 */
class Stepper extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'stepper';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Stepper steps
     *
     * @var array
     */
    protected array $steps = [];

    /**
     * Current step (0-indexed)
     *
     * @var int
     */
    protected int $currentStep = 0;

    /**
     * Vertical orientation
     *
     * @var bool
     */
    protected bool $vertical = false;

    /**
     * Show step numbers
     *
     * @var bool
     */
    protected bool $showNumbers = true;

    /**
     * Clickable steps
     *
     * @var bool
     */
    protected bool $clickable = false;

    /**
     * Show connector lines
     *
     * @var bool
     */
    protected bool $connectors = true;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['steps'])) {
            $this->steps = $config['steps'];
        }

        if (isset($config['currentStep'])) {
            $this->currentStep = (int) $config['currentStep'];
        }

        if (isset($config['vertical'])) {
            $this->vertical = (bool) $config['vertical'];
        }

        if (isset($config['showNumbers'])) {
            $this->showNumbers = (bool) $config['showNumbers'];
        }

        if (isset($config['clickable'])) {
            $this->clickable = (bool) $config['clickable'];
        }

        if (isset($config['connectors'])) {
            $this->connectors = (bool) $config['connectors'];
        }
    }

    /**
     * Set steps
     *
     * @param array $steps
     * @return static
     */
    public function steps(array $steps): static
    {
        $this->steps = $steps;
        return $this;
    }

    /**
     * Add step
     *
     * @param string $label
     * @param string|null $description
     * @param string|null $icon
     * @return static
     */
    public function addStep(string $label, ?string $description = null, ?string $icon = null): static
    {
        $step = ['label' => $label];
        if ($description !== null) {
            $step['description'] = $description;
        }
        if ($icon !== null) {
            $step['icon'] = $icon;
        }
        $this->steps[] = $step;
        return $this;
    }

    /**
     * Set current step
     *
     * @param int $step
     * @return static
     */
    public function currentStep(int $step): static
    {
        $this->currentStep = $step;
        return $this;
    }

    /**
     * Set vertical orientation
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
     * Show/hide step numbers
     *
     * @param bool $show
     * @return static
     */
    public function showNumbers(bool $show = true): static
    {
        $this->showNumbers = $show;
        return $this;
    }

    /**
     * Enable clickable steps
     *
     * @param bool $clickable
     * @return static
     */
    public function clickable(bool $clickable = true): static
    {
        $this->clickable = $clickable;
        return $this;
    }

    /**
     * Show/hide connectors
     *
     * @param bool $show
     * @return static
     */
    public function connectors(bool $show = true): static
    {
        $this->connectors = $show;
        return $this;
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('stepper'));

        if ($this->vertical) {
            $this->addClass(CssPrefix::cls('stepper-vertical'));
        } else {
            $this->addClass(CssPrefix::cls('stepper-horizontal'));
        }

        if (!$this->connectors) {
            $this->addClass(CssPrefix::cls('stepper-no-connectors'));
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

        if ($this->clickable) {
            $attrs[CssPrefix::data('ui-init')] = 'stepper';
            $config = [
                'clickable' => true,
                'currentStep' => $this->currentStep,
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

        foreach ($this->steps as $index => $step) {
            $stepClass = CssPrefix::cls('stepper-step');

            if ($index < $this->currentStep) {
                $stepClass .= ' ' . CssPrefix::cls('stepper-completed');
            } elseif ($index === $this->currentStep) {
                $stepClass .= ' ' . CssPrefix::cls('stepper-active');
            }

            $tag = $this->clickable ? 'button' : 'div';
            $html .= '<' . $tag . ' class="' . $stepClass . '"';

            if ($this->clickable) {
                $html .= ' type="button" ' . CssPrefix::data('step') . '="' . $index . '"';
            }

            $html .= '>';

            // Step indicator
            $html .= '<div class="' . CssPrefix::cls('stepper-indicator') . '">';

            if (isset($step['icon'])) {
                $html .= '<span class="material-icons">' . e($step['icon']) . '</span>';
            } elseif ($index < $this->currentStep) {
                $html .= '<span class="material-icons">check</span>';
            } elseif ($this->showNumbers) {
                $html .= '<span>' . ($index + 1) . '</span>';
            }

            $html .= '</div>';

            // Step content
            $html .= '<div class="' . CssPrefix::cls('stepper-content') . '">';
            $html .= '<span class="' . CssPrefix::cls('stepper-label') . '">' . e($step['label']) . '</span>';

            if (isset($step['description'])) {
                $html .= '<span class="' . CssPrefix::cls('stepper-description') . '">' . e($step['description']) . '</span>';
            }

            $html .= '</div>';

            // Connector
            if ($this->connectors && $index < count($this->steps) - 1) {
                $connectorClass = CssPrefix::cls('stepper-connector');
                if ($index < $this->currentStep) {
                    $connectorClass .= ' ' . CssPrefix::cls('stepper-connector-completed');
                }
                $html .= '<div class="' . $connectorClass . '"></div>';
            }

            $html .= '</' . $tag . '>';
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

        if (!empty($this->steps)) {
            $config['steps'] = $this->steps;
        }

        if ($this->currentStep !== 0) {
            $config['currentStep'] = $this->currentStep;
        }

        if ($this->vertical) {
            $config['vertical'] = true;
        }

        if (!$this->showNumbers) {
            $config['showNumbers'] = false;
        }

        if ($this->clickable) {
            $config['clickable'] = true;
        }

        if (!$this->connectors) {
            $config['connectors'] = false;
        }

        return $config;
    }
}
