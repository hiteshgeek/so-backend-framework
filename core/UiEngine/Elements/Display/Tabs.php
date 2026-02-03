<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Contracts\ElementInterface;
use Core\UiEngine\Support\CssPrefix;

/**
 * Tabs - Tab container display element
 *
 * Creates Bootstrap-style tabs with content panels.
 */
class Tabs extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'tabs';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Tab items
     *
     * @var array
     */
    protected array $tabs = [];

    /**
     * Active tab index
     *
     * @var int
     */
    protected int $activeTab = 0;

    /**
     * Tab style (underline, pills, boxed, ghost, bordered)
     *
     * @var string
     */
    protected string $style = 'underline';

    /**
     * Vertical tabs
     *
     * @var bool
     */
    protected bool $vertical = false;

    /**
     * Fill width
     *
     * @var bool
     */
    protected bool $fill = false;

    /**
     * Justified tabs
     *
     * @var bool
     */
    protected bool $justified = false;

    /**
     * Tab size (sm, lg)
     *
     * @var string|null
     */
    protected ?string $size = null;

    /**
     * Centered tabs
     *
     * @var bool
     */
    protected bool $centered = false;

    /**
     * Right aligned tabs
     *
     * @var bool
     */
    protected bool $end = false;

    /**
     * Color variant
     *
     * @var string|null
     */
    protected ?string $variant = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['tabs'])) {
            $this->tabs = $config['tabs'];
        }

        if (isset($config['activeTab'])) {
            $this->activeTab = (int) $config['activeTab'];
        }

        if (isset($config['style'])) {
            $this->style = $config['style'];
        }

        if (isset($config['vertical'])) {
            $this->vertical = (bool) $config['vertical'];
        }

        if (isset($config['fill'])) {
            $this->fill = (bool) $config['fill'];
        }

        if (isset($config['justified'])) {
            $this->justified = (bool) $config['justified'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        if (isset($config['centered'])) {
            $this->centered = (bool) $config['centered'];
        }

        if (isset($config['end'])) {
            $this->end = (bool) $config['end'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }
    }

    /**
     * Add a tab
     *
     * @param string $title Tab title
     * @param string|ElementInterface|array $content Tab content
     * @param string|null $icon Tab icon
     * @param bool $disabled
     * @return static
     */
    public function tab(string $title, string|ElementInterface|array $content, ?string $icon = null, bool $disabled = false): static
    {
        $this->tabs[] = [
            'title' => $title,
            'content' => $content,
            'icon' => $icon,
            'disabled' => $disabled,
        ];

        return $this;
    }

    /**
     * Set active tab
     *
     * @param int $index
     * @return static
     */
    public function activeTab(int $index): static
    {
        $this->activeTab = $index;
        return $this;
    }

    /**
     * Set tab style
     *
     * @param string $style tabs|pills
     * @return static
     */
    public function style(string $style): static
    {
        $this->style = $style;
        return $this;
    }

    /**
     * Use pill style
     *
     * @return static
     */
    public function pills(): static
    {
        return $this->style('pills');
    }

    /**
     * Use boxed/segmented style
     *
     * @return static
     */
    public function boxed(): static
    {
        return $this->style('boxed');
    }

    /**
     * Use ghost style
     *
     * @return static
     */
    public function ghost(): static
    {
        return $this->style('ghost');
    }

    /**
     * Use bordered style
     *
     * @return static
     */
    public function bordered(): static
    {
        return $this->style('bordered');
    }

    /**
     * Use vertical layout
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
     * Fill width
     *
     * @param bool $fill
     * @return static
     */
    public function fill(bool $fill = true): static
    {
        $this->fill = $fill;
        return $this;
    }

    /**
     * Justify tabs
     *
     * @param bool $justified
     * @return static
     */
    public function justified(bool $justified = true): static
    {
        $this->justified = $justified;
        return $this;
    }

    /**
     * Set tab size
     *
     * @param string $size sm|lg
     * @return static
     */
    public function size(string $size): static
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Small tabs
     *
     * @return static
     */
    public function small(): static
    {
        return $this->size('sm');
    }

    /**
     * Large tabs
     *
     * @return static
     */
    public function large(): static
    {
        return $this->size('lg');
    }

    /**
     * Center tabs
     *
     * @param bool $centered
     * @return static
     */
    public function centered(bool $centered = true): static
    {
        $this->centered = $centered;
        return $this;
    }

    /**
     * Right-align tabs
     *
     * @param bool $end
     * @return static
     */
    public function end(bool $end = true): static
    {
        $this->end = $end;
        return $this;
    }

    /**
     * Set color variant
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
     * Primary color variant
     *
     * @return static
     */
    public function primary(): static
    {
        return $this->variant('primary');
    }

    /**
     * Success color variant
     *
     * @return static
     */
    public function success(): static
    {
        return $this->variant('success');
    }

    /**
     * Danger color variant
     *
     * @return static
     */
    public function danger(): static
    {
        return $this->variant('danger');
    }

    /**
     * Warning color variant
     *
     * @return static
     */
    public function warning(): static
    {
        return $this->variant('warning');
    }

    /**
     * Info color variant
     *
     * @return static
     */
    public function info(): static
    {
        return $this->variant('info');
    }

    /**
     * Secondary color variant
     *
     * @return static
     */
    public function secondary(): static
    {
        return $this->variant('secondary');
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        // Container class for vertical tabs
        if ($this->vertical) {
            $this->addClass(CssPrefix::cls('tabs-container'));
            $this->addClass(CssPrefix::cls('tabs-container-vertical'));
        }

        return parent::buildClassString();
    }

    /**
     * Render the content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $baseId = $this->id ?? 'tabs-' . uniqid();

        $html = '';

        // Tab navigation
        $html .= $this->renderNavigation($baseId);

        // Tab content
        $html .= $this->renderPanels($baseId);

        return $html;
    }

    /**
     * Render tab navigation
     *
     * @param string $baseId
     * @return string
     */
    protected function renderNavigation(string $baseId): string
    {
        // Build tab container classes: so-tabs, so-tabs-pills, etc.
        $tabsClass = CssPrefix::cls('tabs');

        // Style variant
        if ($this->style !== 'underline') {
            $tabsClass .= ' ' . CssPrefix::cls('tabs', $this->style);
        }

        // Vertical
        if ($this->vertical) {
            $tabsClass .= ' ' . CssPrefix::cls('tabs-vertical');
        }

        // Fill
        if ($this->fill) {
            $tabsClass .= ' ' . CssPrefix::cls('tabs-fill');
        }

        // Justified
        if ($this->justified) {
            $tabsClass .= ' ' . CssPrefix::cls('tabs-justified');
        }

        // Size
        if ($this->size !== null) {
            $tabsClass .= ' ' . CssPrefix::cls('tabs', $this->size);
        }

        // Centered
        if ($this->centered) {
            $tabsClass .= ' ' . CssPrefix::cls('tabs-center');
        }

        // End (right-aligned)
        if ($this->end) {
            $tabsClass .= ' ' . CssPrefix::cls('tabs-end');
        }

        // Color variant
        if ($this->variant !== null) {
            $tabsClass .= ' ' . CssPrefix::cls('tabs', $this->variant);
        }

        $html = '<div class="' . $tabsClass . '" role="tablist" ' . CssPrefix::data('tabs') . '>';

        foreach ($this->tabs as $index => $tab) {
            $tabId = $baseId . '-tab-' . $index;
            $panelId = $baseId . '-panel-' . $index;
            $isActive = $index === $this->activeTab;
            $isDisabled = $tab['disabled'] ?? false;

            // Tab button class: so-tab
            $tabClass = CssPrefix::cls('tab');
            if ($isActive) {
                $tabClass .= ' ' . CssPrefix::cls('active');
            }
            if ($isDisabled) {
                $tabClass .= ' ' . CssPrefix::cls('disabled');
            }

            $html .= '<button class="' . $tabClass . '"';
            $html .= ' id="' . e($tabId) . '"';
            $html .= ' ' . CssPrefix::data('target') . '="#' . e($panelId) . '"';
            $html .= ' type="button"';
            $html .= ' role="tab"';
            $html .= ' aria-controls="' . e($panelId) . '"';
            $html .= ' aria-selected="' . ($isActive ? 'true' : 'false') . '"';

            if ($isDisabled) {
                $html .= ' disabled';
            }

            $html .= '>';

            // Icon
            if (isset($tab['icon'])) {
                $html .= '<span class="material-icons">' . e($tab['icon']) . '</span>';
            }

            $html .= e($tab['title']);
            $html .= '</button>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Render tab panels
     *
     * @param string $baseId
     * @return string
     */
    protected function renderPanels(string $baseId): string
    {
        $contentClass = CssPrefix::cls('tab-content');

        $html = '<div class="' . $contentClass . '">';

        foreach ($this->tabs as $index => $tab) {
            $tabId = $baseId . '-tab-' . $index;
            $panelId = $baseId . '-panel-' . $index;
            $isActive = $index === $this->activeTab;

            $panelClass = CssPrefix::cls('tab-pane') . ' ' . CssPrefix::cls('fade');
            if ($isActive) {
                $panelClass .= ' ' . CssPrefix::cls('show') . ' ' . CssPrefix::cls('active');
            }

            $html .= '<div class="' . $panelClass . '"';
            $html .= ' id="' . e($panelId) . '"';
            $html .= ' role="tabpanel"';
            $html .= ' aria-labelledby="' . e($tabId) . '">';

            // Render content
            $content = $tab['content'];
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

        if (!empty($this->tabs)) {
            $config['tabs'] = array_map(function ($tab) {
                $tabConfig = [
                    'title' => $tab['title'],
                ];

                if ($tab['content'] instanceof ElementInterface) {
                    $tabConfig['content'] = $tab['content']->toArray();
                } else {
                    $tabConfig['content'] = $tab['content'];
                }

                if (isset($tab['icon'])) {
                    $tabConfig['icon'] = $tab['icon'];
                }

                if ($tab['disabled'] ?? false) {
                    $tabConfig['disabled'] = true;
                }

                return $tabConfig;
            }, $this->tabs);
        }

        if ($this->activeTab !== 0) {
            $config['activeTab'] = $this->activeTab;
        }

        if ($this->style !== 'underline') {
            $config['style'] = $this->style;
        }

        if ($this->vertical) {
            $config['vertical'] = true;
        }

        if ($this->fill) {
            $config['fill'] = true;
        }

        if ($this->justified) {
            $config['justified'] = true;
        }

        if ($this->size !== null) {
            $config['size'] = $this->size;
        }

        if ($this->centered) {
            $config['centered'] = true;
        }

        if ($this->end) {
            $config['end'] = true;
        }

        if ($this->variant !== null) {
            $config['variant'] = $this->variant;
        }

        return $config;
    }
}
