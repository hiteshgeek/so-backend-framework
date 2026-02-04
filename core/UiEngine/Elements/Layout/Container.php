<?php

namespace Core\UiEngine\Elements\Layout;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Contracts\ElementInterface;
use Core\UiEngine\Support\CssPrefix;
use Core\UiEngine\Support\ElementFactory;

/**
 * Container - Generic container element
 *
 * Creates a Bootstrap-style container with optional fluid mode.
 * Uses so-container classes from the frontend framework.
 */
class Container extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'container';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Whether the container is fluid (full-width)
     *
     * @var bool
     */
    protected bool $fluid = false;

    /**
     * Responsive container breakpoint
     *
     * @var string|null
     */
    protected ?string $breakpoint = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['fluid'])) {
            $this->fluid = (bool) $config['fluid'];
        }

        if (isset($config['breakpoint'])) {
            $this->breakpoint = $config['breakpoint'];
        }
    }

    /**
     * Set container to fluid mode
     *
     * @param bool $fluid
     * @return static
     */
    public function fluid(bool $fluid = true): static
    {
        $this->fluid = $fluid;
        return $this;
    }

    /**
     * Set responsive breakpoint
     *
     * Container is 100% wide until the specified breakpoint
     *
     * @param string $breakpoint sm|md|lg|xl|xxl
     * @return static
     */
    public function breakpoint(string $breakpoint): static
    {
        $this->breakpoint = $breakpoint;
        return $this;
    }

    /**
     * Set container to be 100% wide until small breakpoint
     *
     * @return static
     */
    public function sm(): static
    {
        return $this->breakpoint('sm');
    }

    /**
     * Set container to be 100% wide until medium breakpoint
     *
     * @return static
     */
    public function md(): static
    {
        return $this->breakpoint('md');
    }

    /**
     * Set container to be 100% wide until large breakpoint
     *
     * @return static
     */
    public function lg(): static
    {
        return $this->breakpoint('lg');
    }

    /**
     * Set container to be 100% wide until extra large breakpoint
     *
     * @return static
     */
    public function xl(): static
    {
        return $this->breakpoint('xl');
    }

    /**
     * Set container to be 100% wide until extra extra large breakpoint
     *
     * @return static
     */
    public function xxl(): static
    {
        return $this->breakpoint('xxl');
    }

    /**
     * Add a row to this container
     *
     * @param array $children Optional children for the row
     * @return static
     */
    public function row(array $children = []): static
    {
        $config = ['type' => 'row'];

        if (!empty($children)) {
            $config['children'] = $children;
        }

        return $this->add(ElementFactory::create($config));
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        if ($this->fluid) {
            $this->addClass(CssPrefix::cls('container-fluid'));
        } elseif ($this->breakpoint !== null) {
            $this->addClass(CssPrefix::cls('container', $this->breakpoint));
        } else {
            $this->addClass(CssPrefix::cls('container'));
        }

        return parent::buildClassString();
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        if ($this->fluid) {
            $config['fluid'] = true;
        }

        if ($this->breakpoint !== null) {
            $config['breakpoint'] = $this->breakpoint;
        }

        return $config;
    }
}
