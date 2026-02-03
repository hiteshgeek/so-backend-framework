<?php

namespace Core\UiEngine\Elements\Layout;

use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Support\CssPrefix;

/**
 * Grid - CSS Grid layout wrapper
 *
 * Provides CSS Grid layout functionality
 */
class Grid extends ContainerElement
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'grid';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'div';

    /**
     * Number of columns
     *
     * @var int|string|null
     */
    protected int|string|null $columns = null;

    /**
     * Number of rows
     *
     * @var int|string|null
     */
    protected int|string|null $rows = null;

    /**
     * Gap between items
     *
     * @var string|null
     */
    protected ?string $gap = null;

    /**
     * Row gap
     *
     * @var string|null
     */
    protected ?string $rowGap = null;

    /**
     * Column gap
     *
     * @var string|null
     */
    protected ?string $columnGap = null;

    /**
     * Justify items
     *
     * @var string|null
     */
    protected ?string $justifyItems = null;

    /**
     * Align items
     *
     * @var string|null
     */
    protected ?string $alignItems = null;

    /**
     * Template areas
     *
     * @var array|null
     */
    protected ?array $areas = null;

    /**
     * Auto flow
     *
     * @var string|null
     */
    protected ?string $autoFlow = null;

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['columns'])) {
            $this->columns = $config['columns'];
        }

        if (isset($config['rows'])) {
            $this->rows = $config['rows'];
        }

        if (isset($config['gap'])) {
            $this->gap = $config['gap'];
        }

        if (isset($config['rowGap'])) {
            $this->rowGap = $config['rowGap'];
        }

        if (isset($config['columnGap'])) {
            $this->columnGap = $config['columnGap'];
        }

        if (isset($config['justifyItems'])) {
            $this->justifyItems = $config['justifyItems'];
        }

        if (isset($config['alignItems'])) {
            $this->alignItems = $config['alignItems'];
        }

        if (isset($config['areas'])) {
            $this->areas = $config['areas'];
        }

        if (isset($config['autoFlow'])) {
            $this->autoFlow = $config['autoFlow'];
        }
    }

    /**
     * Set number of columns
     *
     * @param int|string $columns
     * @return static
     */
    public function columns(int|string $columns): static
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Set number of rows
     *
     * @param int|string $rows
     * @return static
     */
    public function rows(int|string $rows): static
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * Set gap
     *
     * @param string $gap
     * @return static
     */
    public function gap(string $gap): static
    {
        $this->gap = $gap;
        return $this;
    }

    /**
     * Set row gap
     *
     * @param string $gap
     * @return static
     */
    public function rowGap(string $gap): static
    {
        $this->rowGap = $gap;
        return $this;
    }

    /**
     * Set column gap
     *
     * @param string $gap
     * @return static
     */
    public function columnGap(string $gap): static
    {
        $this->columnGap = $gap;
        return $this;
    }

    /**
     * Set justify items
     *
     * @param string $value
     * @return static
     */
    public function justifyItems(string $value): static
    {
        $this->justifyItems = $value;
        return $this;
    }

    /**
     * Set align items
     *
     * @param string $value
     * @return static
     */
    public function alignItems(string $value): static
    {
        $this->alignItems = $value;
        return $this;
    }

    /**
     * Set template areas
     *
     * @param array $areas
     * @return static
     */
    public function areas(array $areas): static
    {
        $this->areas = $areas;
        return $this;
    }

    /**
     * Set auto flow
     *
     * @param string $flow
     * @return static
     */
    public function autoFlow(string $flow): static
    {
        $this->autoFlow = $flow;
        return $this;
    }

    /**
     * Auto flow row
     *
     * @return static
     */
    public function flowRow(): static
    {
        return $this->autoFlow('row');
    }

    /**
     * Auto flow column
     *
     * @return static
     */
    public function flowColumn(): static
    {
        return $this->autoFlow('column');
    }

    /**
     * Auto flow dense
     *
     * @return static
     */
    public function flowDense(): static
    {
        return $this->autoFlow('dense');
    }

    /**
     * Build CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('d-grid'));

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

        $styles = [];

        if ($this->columns !== null) {
            if (is_int($this->columns)) {
                $styles[] = 'grid-template-columns: repeat(' . $this->columns . ', 1fr)';
            } else {
                $styles[] = 'grid-template-columns: ' . $this->columns;
            }
        }

        if ($this->rows !== null) {
            if (is_int($this->rows)) {
                $styles[] = 'grid-template-rows: repeat(' . $this->rows . ', 1fr)';
            } else {
                $styles[] = 'grid-template-rows: ' . $this->rows;
            }
        }

        if ($this->gap !== null) {
            $styles[] = 'gap: ' . $this->gap;
        }

        if ($this->rowGap !== null) {
            $styles[] = 'row-gap: ' . $this->rowGap;
        }

        if ($this->columnGap !== null) {
            $styles[] = 'column-gap: ' . $this->columnGap;
        }

        if ($this->justifyItems !== null) {
            $styles[] = 'justify-items: ' . $this->justifyItems;
        }

        if ($this->alignItems !== null) {
            $styles[] = 'align-items: ' . $this->alignItems;
        }

        if ($this->areas !== null) {
            $areasStr = implode(' ', array_map(fn($row) => '"' . $row . '"', $this->areas));
            $styles[] = 'grid-template-areas: ' . $areasStr;
        }

        if ($this->autoFlow !== null) {
            $styles[] = 'grid-auto-flow: ' . $this->autoFlow;
        }

        if (!empty($styles)) {
            $existing = $attrs['style'] ?? '';
            $attrs['style'] = trim($existing . '; ' . implode('; ', $styles), '; ');
        }

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

        if ($this->columns !== null) {
            $config['columns'] = $this->columns;
        }

        if ($this->rows !== null) {
            $config['rows'] = $this->rows;
        }

        if ($this->gap !== null) {
            $config['gap'] = $this->gap;
        }

        if ($this->rowGap !== null) {
            $config['rowGap'] = $this->rowGap;
        }

        if ($this->columnGap !== null) {
            $config['columnGap'] = $this->columnGap;
        }

        if ($this->justifyItems !== null) {
            $config['justifyItems'] = $this->justifyItems;
        }

        if ($this->alignItems !== null) {
            $config['alignItems'] = $this->alignItems;
        }

        if ($this->areas !== null) {
            $config['areas'] = $this->areas;
        }

        if ($this->autoFlow !== null) {
            $config['autoFlow'] = $this->autoFlow;
        }

        return $config;
    }
}
