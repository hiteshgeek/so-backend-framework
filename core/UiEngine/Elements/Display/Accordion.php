<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Contracts\ElementInterface;
use Core\UiEngine\Support\CssPrefix;

/**
 * Accordion - Accordion display element
 *
 * Creates Bootstrap-style accordion with collapsible items.
 */
class Accordion extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'accordion';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Accordion items
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Active/open item index (-1 for none)
     *
     * @var int
     */
    protected int $activeItem = 0;

    /**
     * Allow multiple items open
     *
     * @var bool
     */
    protected bool $alwaysOpen = false;

    /**
     * Flush style (no borders)
     *
     * @var bool
     */
    protected bool $flush = false;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['items'])) {
            $this->items = $config['items'];
        }

        if (isset($config['activeItem'])) {
            $this->activeItem = (int) $config['activeItem'];
        }

        if (isset($config['alwaysOpen'])) {
            $this->alwaysOpen = (bool) $config['alwaysOpen'];
        }

        if (isset($config['flush'])) {
            $this->flush = (bool) $config['flush'];
        }
    }

    /**
     * Add an accordion item
     *
     * @param string $title Item header title
     * @param string|ElementInterface|array $content Item content
     * @param bool $open Start expanded
     * @return static
     */
    public function item(string $title, string|ElementInterface|array $content, bool $open = false): static
    {
        $index = count($this->items);

        $this->items[] = [
            'title' => $title,
            'content' => $content,
        ];

        if ($open) {
            $this->activeItem = $index;
        }

        return $this;
    }

    /**
     * Set active item
     *
     * @param int $index
     * @return static
     */
    public function activeItem(int $index): static
    {
        $this->activeItem = $index;
        return $this;
    }

    /**
     * Start with all collapsed
     *
     * @return static
     */
    public function collapsed(): static
    {
        $this->activeItem = -1;
        return $this;
    }

    /**
     * Allow multiple items to be open
     *
     * @param bool $alwaysOpen
     * @return static
     */
    public function alwaysOpen(bool $alwaysOpen = true): static
    {
        $this->alwaysOpen = $alwaysOpen;
        return $this;
    }

    /**
     * Use flush style
     *
     * @param bool $flush
     * @return static
     */
    public function flush(bool $flush = true): static
    {
        $this->flush = $flush;
        return $this;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('accordion'));

        if ($this->flush) {
            $this->addClass(CssPrefix::cls('accordion-flush'));
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

        // Add data-so-accordion attribute for JS initialization
        $attrs[CssPrefix::data('accordion')] = '';

        return $attrs;
    }

    /**
     * Render the content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $baseId = $this->id ?? 'accordion-' . uniqid();

        $html = '';

        foreach ($this->items as $index => $item) {
            $html .= $this->renderItem($item, $index, $baseId);
        }

        return $html;
    }

    /**
     * Render an accordion item
     *
     * @param array $item
     * @param int $index
     * @param string $baseId
     * @return string
     */
    protected function renderItem(array $item, int $index, string $baseId): string
    {
        $headerId = $baseId . '-header-' . $index;
        $collapseId = $baseId . '-collapse-' . $index;
        $isOpen = $index === $this->activeItem;

        $html = '<div class="' . CssPrefix::cls('accordion-item') . '">';

        // Header
        $html .= '<h2 class="' . CssPrefix::cls('accordion-header') . '" id="' . e($headerId) . '">';
        $html .= '<button class="' . CssPrefix::cls('accordion-button') . ($isOpen ? '' : ' ' . CssPrefix::cls('collapsed')) . '"';
        $html .= ' type="button"';
        $html .= ' ' . CssPrefix::data('toggle') . '="collapse"';
        $html .= ' ' . CssPrefix::data('target') . '="#' . e($collapseId) . '"';
        $html .= ' aria-expanded="' . ($isOpen ? 'true' : 'false') . '"';
        $html .= ' aria-controls="' . e($collapseId) . '">';
        $html .= e($item['title']);
        $html .= '</button>';
        $html .= '</h2>';

        // Collapse
        $collapseClass = CssPrefix::cls('accordion-collapse') . ' ' . CssPrefix::cls('collapse');
        if ($isOpen) {
            $collapseClass .= ' ' . CssPrefix::cls('show');
        }

        $html .= '<div id="' . e($collapseId) . '"';
        $html .= ' class="' . $collapseClass . '"';
        $html .= ' aria-labelledby="' . e($headerId) . '"';

        // Only add data-so-parent if not alwaysOpen
        if (!$this->alwaysOpen) {
            $html .= ' ' . CssPrefix::data('parent') . '="#' . e($baseId) . '"';
        }

        $html .= '>';
        $html .= '<div class="' . CssPrefix::cls('accordion-body') . '">';

        // Content
        $content = $item['content'];
        if ($content instanceof ElementInterface) {
            $html .= $content->render();
        } elseif (is_array($content)) {
            foreach ($content as $child) {
                if ($child instanceof ElementInterface) {
                    $html .= $child->render();
                } elseif (is_string($child)) {
                    $html .= e($child);
                }
            }
        } else {
            $html .= e($content);
        }

        $html .= '</div></div></div>';

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

        if (!empty($this->items)) {
            $config['items'] = array_map(function ($item) {
                $itemConfig = [
                    'title' => $item['title'],
                ];

                if ($item['content'] instanceof ElementInterface) {
                    $itemConfig['content'] = $item['content']->toArray();
                } else {
                    $itemConfig['content'] = $item['content'];
                }

                return $itemConfig;
            }, $this->items);
        }

        if ($this->activeItem !== 0) {
            $config['activeItem'] = $this->activeItem;
        }

        if ($this->alwaysOpen) {
            $config['alwaysOpen'] = true;
        }

        if ($this->flush) {
            $config['flush'] = true;
        }

        return $config;
    }
}
