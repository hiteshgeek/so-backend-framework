<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Table - Data table display element
 *
 * Creates Bootstrap-style tables with various options.
 */
class Table extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'table';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'table';

    /**
     * Table columns configuration
     *
     * @var array
     */
    protected array $columns = [];

    /**
     * Table data rows
     *
     * @var array
     */
    protected array $rows = [];

    /**
     * Table variant
     *
     * @var string|null
     */
    protected ?string $variant = null;

    /**
     * Striped rows
     *
     * @var bool
     */
    protected bool $striped = false;

    /**
     * Bordered table
     *
     * @var bool
     */
    protected bool $bordered = false;

    /**
     * Borderless table
     *
     * @var bool
     */
    protected bool $borderless = false;

    /**
     * Hoverable rows
     *
     * @var bool
     */
    protected bool $hover = false;

    /**
     * Small/compact table
     *
     * @var bool
     */
    protected bool $small = false;

    /**
     * Responsive wrapper
     *
     * @var bool|string
     */
    protected bool|string $responsive = false;

    /**
     * Caption text
     *
     * @var string|null
     */
    protected ?string $caption = null;

    /**
     * Caption position
     *
     * @var string
     */
    protected string $captionPosition = 'bottom';

    /**
     * Show table header
     *
     * @var bool
     */
    protected bool $showHeader = true;

    /**
     * Header variant
     *
     * @var string|null
     */
    protected ?string $headerVariant = null;

    /**
     * Table footer rows
     *
     * @var array
     */
    protected array $footer = [];

    /**
     * Empty message
     *
     * @var string
     */
    protected string $emptyMessage = 'No data available';

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

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['striped'])) {
            $this->striped = (bool) $config['striped'];
        }

        if (isset($config['bordered'])) {
            $this->bordered = (bool) $config['bordered'];
        }

        if (isset($config['borderless'])) {
            $this->borderless = (bool) $config['borderless'];
        }

        if (isset($config['hover'])) {
            $this->hover = (bool) $config['hover'];
        }

        if (isset($config['small'])) {
            $this->small = (bool) $config['small'];
        }

        if (isset($config['responsive'])) {
            $this->responsive = $config['responsive'];
        }

        if (isset($config['caption'])) {
            $this->caption = $config['caption'];
        }

        if (isset($config['captionPosition'])) {
            $this->captionPosition = $config['captionPosition'];
        }

        if (isset($config['showHeader'])) {
            $this->showHeader = (bool) $config['showHeader'];
        }

        if (isset($config['headerVariant'])) {
            $this->headerVariant = $config['headerVariant'];
        }

        if (isset($config['footer'])) {
            $this->footer = $config['footer'];
        }

        if (isset($config['emptyMessage'])) {
            $this->emptyMessage = $config['emptyMessage'];
        }
    }

    /**
     * Set columns
     *
     * @param array $columns Array of column configs: ['key' => 'field', 'label' => 'Label', 'sortable' => true]
     * @return static
     */
    public function columns(array $columns): static
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Add a column
     *
     * @param string $key Field key
     * @param string $label Column label
     * @param array $options Additional options
     * @return static
     */
    public function column(string $key, string $label, array $options = []): static
    {
        $this->columns[] = array_merge([
            'key' => $key,
            'label' => $label,
        ], $options);

        return $this;
    }

    /**
     * Set rows data
     *
     * @param array $rows
     * @return static
     */
    public function rows(array $rows): static
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * Add a row
     *
     * @param array $row
     * @return static
     */
    public function row(array $row): static
    {
        $this->rows[] = $row;
        return $this;
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
     * Dark variant
     *
     * @return static
     */
    public function dark(): static
    {
        return $this->variant('dark');
    }

    /**
     * Enable striped rows
     *
     * @param bool $striped
     * @return static
     */
    public function striped(bool $striped = true): static
    {
        $this->striped = $striped;
        return $this;
    }

    /**
     * Enable borders
     *
     * @param bool $bordered
     * @return static
     */
    public function bordered(bool $bordered = true): static
    {
        $this->bordered = $bordered;
        return $this;
    }

    /**
     * Remove borders
     *
     * @param bool $borderless
     * @return static
     */
    public function borderless(bool $borderless = true): static
    {
        $this->borderless = $borderless;
        return $this;
    }

    /**
     * Enable hover effect
     *
     * @param bool $hover
     * @return static
     */
    public function hover(bool $hover = true): static
    {
        $this->hover = $hover;
        return $this;
    }

    /**
     * Use small/compact size
     *
     * @param bool $small
     * @return static
     */
    public function small(bool $small = true): static
    {
        $this->small = $small;
        return $this;
    }

    /**
     * Enable responsive wrapper
     *
     * @param bool|string $responsive true or breakpoint (sm, md, lg, xl, xxl)
     * @return static
     */
    public function responsive(bool|string $responsive = true): static
    {
        $this->responsive = $responsive;
        return $this;
    }

    /**
     * Set caption
     *
     * @param string $caption
     * @param string $position top|bottom
     * @return static
     */
    public function caption(string $caption, string $position = 'bottom'): static
    {
        $this->caption = $caption;
        $this->captionPosition = $position;
        return $this;
    }

    /**
     * Hide header
     *
     * @return static
     */
    public function hideHeader(): static
    {
        $this->showHeader = false;
        return $this;
    }

    /**
     * Set header variant
     *
     * @param string $variant light|dark
     * @return static
     */
    public function headerVariant(string $variant): static
    {
        $this->headerVariant = $variant;
        return $this;
    }

    /**
     * Set footer rows
     *
     * @param array $footer
     * @return static
     */
    public function footer(array $footer): static
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * Set empty message
     *
     * @param string $message
     * @return static
     */
    public function emptyMessage(string $message): static
    {
        $this->emptyMessage = $message;
        return $this;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('table'));

        if ($this->variant !== null) {
            $this->addClass(CssPrefix::cls('table', $this->variant));
        }

        if ($this->striped) {
            $this->addClass(CssPrefix::cls('table-striped'));
        }

        if ($this->bordered) {
            $this->addClass(CssPrefix::cls('table-bordered'));
        }

        if ($this->borderless) {
            $this->addClass(CssPrefix::cls('table-borderless'));
        }

        if ($this->hover) {
            $this->addClass(CssPrefix::cls('table-hover'));
        }

        if ($this->small) {
            $this->addClass(CssPrefix::cls('table-sm'));
        }

        if ($this->captionPosition === 'top') {
            $this->addClass(CssPrefix::cls('caption-top'));
        }

        return parent::buildClassString();
    }

    /**
     * Render the element
     *
     * @return string
     */
    public function render(): string
    {
        $tableHtml = parent::render();

        // Wrap in responsive container if needed
        if ($this->responsive !== false) {
            $wrapperClass = CssPrefix::cls('table-responsive');

            if (is_string($this->responsive)) {
                $wrapperClass = CssPrefix::cls('table-responsive', $this->responsive);
            }

            $tableHtml = '<div class="' . $wrapperClass . '">' . $tableHtml . '</div>';
        }

        return $tableHtml;
    }

    /**
     * Render the content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Caption
        if ($this->caption !== null) {
            $html .= '<caption>' . e($this->caption) . '</caption>';
        }

        // Header
        if ($this->showHeader && !empty($this->columns)) {
            $html .= $this->renderHeader();
        }

        // Body
        $html .= $this->renderBody();

        // Footer
        if (!empty($this->footer)) {
            $html .= $this->renderFooter();
        }

        return $html;
    }

    /**
     * Render table header
     *
     * @return string
     */
    protected function renderHeader(): string
    {
        $theadClass = '';

        if ($this->headerVariant !== null) {
            $theadClass = ' class="' . CssPrefix::cls('table', $this->headerVariant) . '"';
        }

        $html = '<thead' . $theadClass . '><tr>';

        foreach ($this->columns as $column) {
            $label = $column['label'] ?? $column['key'] ?? '';
            $attrs = '';

            if (isset($column['width'])) {
                $attrs .= ' style="width: ' . e($column['width']) . '"';
            }

            if (isset($column['class'])) {
                $attrs .= ' class="' . e($column['class']) . '"';
            }

            $html .= '<th' . $attrs . '>' . e($label) . '</th>';
        }

        $html .= '</tr></thead>';

        return $html;
    }

    /**
     * Render table body
     *
     * @return string
     */
    protected function renderBody(): string
    {
        $html = '<tbody>';

        if (empty($this->rows)) {
            // Empty state
            $colspan = count($this->columns) ?: 1;
            $html .= '<tr><td colspan="' . $colspan . '" class="' . CssPrefix::cls('text-center') . ' ' . CssPrefix::cls('text-muted') . '">';
            $html .= e($this->emptyMessage);
            $html .= '</td></tr>';
        } else {
            foreach ($this->rows as $row) {
                $html .= $this->renderRow($row);
            }
        }

        $html .= '</tbody>';

        return $html;
    }

    /**
     * Render a table row
     *
     * @param array $row
     * @return string
     */
    protected function renderRow(array $row): string
    {
        $rowClass = '';
        $rowAttrs = '';

        // Check for row variant
        if (isset($row['_variant'])) {
            $rowClass = CssPrefix::cls('table', $row['_variant']);
        }

        // Check for custom row class
        if (isset($row['_class'])) {
            $rowClass .= ' ' . $row['_class'];
        }

        if ($rowClass !== '') {
            $rowAttrs .= ' class="' . trim($rowClass) . '"';
        }

        $html = '<tr' . $rowAttrs . '>';

        foreach ($this->columns as $column) {
            $key = $column['key'] ?? '';
            $value = $row[$key] ?? '';

            $cellClass = '';
            if (isset($column['cellClass'])) {
                $cellClass = ' class="' . e($column['cellClass']) . '"';
            }

            // Check for custom cell renderer
            if (isset($column['render']) && is_callable($column['render'])) {
                $html .= '<td' . $cellClass . '>' . $column['render']($value, $row) . '</td>';
            } else {
                $html .= '<td' . $cellClass . '>' . e($value) . '</td>';
            }
        }

        $html .= '</tr>';

        return $html;
    }

    /**
     * Render table footer
     *
     * @return string
     */
    protected function renderFooter(): string
    {
        $html = '<tfoot>';

        foreach ($this->footer as $row) {
            $html .= '<tr>';

            foreach ($row as $cell) {
                $attrs = '';

                if (is_array($cell)) {
                    if (isset($cell['colspan'])) {
                        $attrs .= ' colspan="' . e($cell['colspan']) . '"';
                    }

                    if (isset($cell['class'])) {
                        $attrs .= ' class="' . e($cell['class']) . '"';
                    }

                    $content = $cell['content'] ?? '';
                } else {
                    $content = $cell;
                }

                $html .= '<td' . $attrs . '>' . e($content) . '</td>';
            }

            $html .= '</tr>';
        }

        $html .= '</tfoot>';

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

        if (!empty($this->columns)) {
            $config['columns'] = $this->columns;
        }

        if (!empty($this->rows)) {
            $config['rows'] = $this->rows;
        }

        if ($this->variant !== null) {
            $config['variant'] = $this->variant;
        }

        if ($this->striped) {
            $config['striped'] = true;
        }

        if ($this->bordered) {
            $config['bordered'] = true;
        }

        if ($this->borderless) {
            $config['borderless'] = true;
        }

        if ($this->hover) {
            $config['hover'] = true;
        }

        if ($this->small) {
            $config['small'] = true;
        }

        if ($this->responsive !== false) {
            $config['responsive'] = $this->responsive;
        }

        if ($this->caption !== null) {
            $config['caption'] = $this->caption;
            $config['captionPosition'] = $this->captionPosition;
        }

        if (!$this->showHeader) {
            $config['showHeader'] = false;
        }

        if ($this->headerVariant !== null) {
            $config['headerVariant'] = $this->headerVariant;
        }

        if (!empty($this->footer)) {
            $config['footer'] = $this->footer;
        }

        if ($this->emptyMessage !== 'No data available') {
            $config['emptyMessage'] = $this->emptyMessage;
        }

        return $config;
    }
}
