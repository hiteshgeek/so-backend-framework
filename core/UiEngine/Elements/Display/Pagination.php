<?php

namespace Core\UiEngine\Elements\Display;

use Core\UiEngine\Elements\Element;
use Core\UiEngine\Support\CssPrefix;

/**
 * Pagination - Page navigation component
 *
 * Creates pagination controls with various styles, sizes, and features
 */
class Pagination extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'pagination';

    /**
     * HTML tag name
     *
     * @var string
     */
    protected string $tagName = 'nav';

    /**
     * Current page number
     *
     * @var int
     */
    protected int $currentPage = 1;

    /**
     * Total number of pages
     *
     * @var int
     */
    protected int $totalPages = 1;

    /**
     * Total number of items
     *
     * @var int|null
     */
    protected ?int $totalItems = null;

    /**
     * Items per page
     *
     * @var int
     */
    protected int $itemsPerPage = 10;

    /**
     * Base URL for pagination links
     *
     * @var string
     */
    protected string $baseUrl = '?page=';

    /**
     * Show previous/next buttons
     *
     * @var bool
     */
    protected bool $showPrevNext = true;

    /**
     * Show first/last buttons
     *
     * @var bool
     */
    protected bool $showFirstLast = false;

    /**
     * Maximum visible page numbers
     *
     * @var int
     */
    protected int $maxVisible = 5;

    /**
     * Pagination size (sm, lg)
     *
     * @var string|null
     */
    protected ?string $size = null;

    /**
     * Pagination style variant
     *
     * @var string|null
     */
    protected ?string $variant = null;

    /**
     * Pagination color
     *
     * @var string|null
     */
    protected ?string $color = null;

    /**
     * Alignment (start, center, end, between)
     *
     * @var string
     */
    protected string $alignment = 'start';

    /**
     * Show page info text
     *
     * @var bool
     */
    protected bool $showInfo = false;

    /**
     * Custom info text template
     *
     * @var string|null
     */
    protected ?string $infoTemplate = null;

    /**
     * Show per-page selector
     *
     * @var bool
     */
    protected bool $showPerPageSelector = false;

    /**
     * Per-page options
     *
     * @var array
     */
    protected array $perPageOptions = [10, 25, 50, 100];

    /**
     * Show jump to page input
     *
     * @var bool
     */
    protected bool $showJumpToPage = false;

    /**
     * Simple mode (prev/next only)
     *
     * @var bool
     */
    protected bool $simpleMode = false;

    /**
     * Use Material Icons for navigation
     *
     * @var bool
     */
    protected bool $useIcons = true;

    /**
     * Custom labels for navigation buttons
     *
     * @var array
     */
    protected array $labels = [
        'first' => 'First',
        'last' => 'Last',
        'previous' => 'Previous',
        'next' => 'Next',
    ];

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['currentPage'])) {
            $this->currentPage = (int) $config['currentPage'];
        }

        if (isset($config['totalPages'])) {
            $this->totalPages = (int) $config['totalPages'];
        }

        if (isset($config['totalItems'])) {
            $this->totalItems = (int) $config['totalItems'];
        }

        if (isset($config['itemsPerPage'])) {
            $this->itemsPerPage = (int) $config['itemsPerPage'];
        }

        // Calculate totalPages from totalItems if provided
        if ($this->totalItems !== null && $this->itemsPerPage > 0) {
            $this->totalPages = (int) ceil($this->totalItems / $this->itemsPerPage);
        }

        if (isset($config['baseUrl'])) {
            $this->baseUrl = $config['baseUrl'];
        }

        if (isset($config['showPrevNext'])) {
            $this->showPrevNext = (bool) $config['showPrevNext'];
        }

        if (isset($config['showFirstLast'])) {
            $this->showFirstLast = (bool) $config['showFirstLast'];
        }

        if (isset($config['maxVisible'])) {
            $this->maxVisible = (int) $config['maxVisible'];
        }

        if (isset($config['size'])) {
            $this->size = $config['size'];
        }

        if (isset($config['variant'])) {
            $this->variant = $config['variant'];
        }

        if (isset($config['color'])) {
            $this->color = $config['color'];
        }

        if (isset($config['alignment'])) {
            $this->alignment = $config['alignment'];
        }

        if (isset($config['showInfo'])) {
            $this->showInfo = (bool) $config['showInfo'];
        }

        if (isset($config['infoTemplate'])) {
            $this->infoTemplate = $config['infoTemplate'];
        }

        if (isset($config['showPerPageSelector'])) {
            $this->showPerPageSelector = (bool) $config['showPerPageSelector'];
        }

        if (isset($config['perPageOptions'])) {
            $this->perPageOptions = $config['perPageOptions'];
        }

        if (isset($config['showJumpToPage'])) {
            $this->showJumpToPage = (bool) $config['showJumpToPage'];
        }

        if (isset($config['simpleMode'])) {
            $this->simpleMode = (bool) $config['simpleMode'];
        }

        if (isset($config['useIcons'])) {
            $this->useIcons = (bool) $config['useIcons'];
        }

        if (isset($config['labels'])) {
            $this->labels = array_merge($this->labels, $config['labels']);
        }
    }

    /**
     * Set current page
     *
     * @param int $page
     * @return static
     */
    public function currentPage(int $page): static
    {
        $this->currentPage = $page;
        return $this;
    }

    /**
     * Set total pages
     *
     * @param int $pages
     * @return static
     */
    public function totalPages(int $pages): static
    {
        $this->totalPages = $pages;
        return $this;
    }

    /**
     * Set from total items and items per page
     *
     * @param int $totalItems
     * @param int $itemsPerPage
     * @return static
     */
    public function fromTotal(int $totalItems, int $itemsPerPage = 10): static
    {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->totalPages = (int) ceil($totalItems / $itemsPerPage);
        return $this;
    }

    /**
     * Set items per page
     *
     * @param int $items
     * @return static
     */
    public function itemsPerPage(int $items): static
    {
        $this->itemsPerPage = $items;
        if ($this->totalItems !== null) {
            $this->totalPages = (int) ceil($this->totalItems / $this->itemsPerPage);
        }
        return $this;
    }

    /**
     * Set base URL
     *
     * @param string $url
     * @return static
     */
    public function baseUrl(string $url): static
    {
        $this->baseUrl = $url;
        return $this;
    }

    /**
     * Show/hide previous/next buttons
     *
     * @param bool $show
     * @return static
     */
    public function showPrevNext(bool $show = true): static
    {
        $this->showPrevNext = $show;
        return $this;
    }

    /**
     * Show/hide first/last buttons
     *
     * @param bool $show
     * @return static
     */
    public function showFirstLast(bool $show = true): static
    {
        $this->showFirstLast = $show;
        return $this;
    }

    /**
     * Set maximum visible page numbers
     *
     * @param int $max
     * @return static
     */
    public function maxVisible(int $max): static
    {
        $this->maxVisible = $max;
        return $this;
    }

    /**
     * Set pagination size
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
     * Small size
     *
     * @return static
     */
    public function small(): static
    {
        return $this->size('sm');
    }

    /**
     * Large size
     *
     * @return static
     */
    public function large(): static
    {
        return $this->size('lg');
    }

    /**
     * Set style variant
     *
     * @param string $variant rounded|outlined|minimal
     * @return static
     */
    public function variant(string $variant): static
    {
        $this->variant = $variant;
        return $this;
    }

    /**
     * Rounded style
     *
     * @return static
     */
    public function rounded(): static
    {
        return $this->variant('rounded');
    }

    /**
     * Outlined style
     *
     * @return static
     */
    public function outlined(): static
    {
        return $this->variant('outlined');
    }

    /**
     * Minimal style
     *
     * @return static
     */
    public function minimal(): static
    {
        return $this->variant('minimal');
    }

    /**
     * Set color
     *
     * @param string $color primary|success|danger|warning|info|light-primary|light-success|etc
     * @return static
     */
    public function color(string $color): static
    {
        $this->color = $color;
        return $this;
    }

    /**
     * Primary color
     *
     * @return static
     */
    public function primary(): static
    {
        return $this->color('primary');
    }

    /**
     * Success color
     *
     * @return static
     */
    public function success(): static
    {
        return $this->color('success');
    }

    /**
     * Danger color
     *
     * @return static
     */
    public function danger(): static
    {
        return $this->color('danger');
    }

    /**
     * Set alignment
     *
     * @param string $alignment start|center|end|between
     * @return static
     */
    public function alignment(string $alignment): static
    {
        $this->alignment = $alignment;
        return $this;
    }

    /**
     * Center align
     *
     * @return static
     */
    public function center(): static
    {
        return $this->alignment('center');
    }

    /**
     * End align
     *
     * @return static
     */
    public function end(): static
    {
        return $this->alignment('end');
    }

    /**
     * Space between (for complex layouts with info/selectors)
     *
     * @return static
     */
    public function between(): static
    {
        return $this->alignment('between');
    }

    /**
     * Show page info
     *
     * @param bool $show
     * @param string|null $template
     * @return static
     */
    public function showInfo(bool $show = true, ?string $template = null): static
    {
        $this->showInfo = $show;
        if ($template !== null) {
            $this->infoTemplate = $template;
        }
        return $this;
    }

    /**
     * Show per-page selector
     *
     * @param bool $show
     * @param array|null $options
     * @return static
     */
    public function showPerPageSelector(bool $show = true, ?array $options = null): static
    {
        $this->showPerPageSelector = $show;
        if ($options !== null) {
            $this->perPageOptions = $options;
        }
        return $this;
    }

    /**
     * Show jump to page input
     *
     * @param bool $show
     * @return static
     */
    public function showJumpToPage(bool $show = true): static
    {
        $this->showJumpToPage = $show;
        return $this;
    }

    /**
     * Simple mode (prev/next only)
     *
     * @param bool $simple
     * @return static
     */
    public function simple(bool $simple = true): static
    {
        $this->simpleMode = $simple;
        return $this;
    }

    /**
     * Use Material Icons
     *
     * @param bool $use
     * @return static
     */
    public function useIcons(bool $use = true): static
    {
        $this->useIcons = $use;
        return $this;
    }

    /**
     * Set custom labels
     *
     * @param array $labels
     * @return static
     */
    public function labels(array $labels): static
    {
        $this->labels = array_merge($this->labels, $labels);
        return $this;
    }

    /**
     * Get page URL
     *
     * @param int $page
     * @return string
     */
    protected function getPageUrl(int $page): string
    {
        return $this->baseUrl . $page;
    }

    /**
     * Build the CSS class string
     *
     * @return string
     */
    public function buildClassString(): string
    {
        $this->addClass(CssPrefix::cls('pagination'));

        // Size
        if ($this->size !== null) {
            $this->addClass(CssPrefix::cls('pagination', $this->size));
        }

        // Variant
        if ($this->variant !== null) {
            $this->addClass(CssPrefix::cls('pagination', $this->variant));
        }

        // Color
        if ($this->color !== null) {
            $this->addClass(CssPrefix::cls('pagination', $this->color));
        }

        // Alignment
        if ($this->alignment !== 'start') {
            $this->addClass(CssPrefix::cls('pagination', $this->alignment));
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

        $attrs['aria-label'] = 'Page navigation';

        // Add data attributes for JavaScript initialization
        if ($this->totalItems !== null) {
            $attrs[CssPrefix::data('total-items')] = $this->totalItems;
        }
        $attrs[CssPrefix::data('items-per-page')] = $this->itemsPerPage;
        $attrs[CssPrefix::data('current-page')] = $this->currentPage;
        $attrs[CssPrefix::data('total-pages')] = $this->totalPages;

        if ($this->showInfo) {
            $attrs[CssPrefix::data('show-page-info')] = 'true';
        }

        if ($this->showFirstLast) {
            $attrs[CssPrefix::data('show-first-last')] = 'true';
        }

        return $attrs;
    }

    /**
     * Render the content
     *
     * @return string
     */
    public function renderContent(): string
    {
        $html = '';

        // Per-page selector (before navigation)
        if ($this->showPerPageSelector && $this->alignment === 'between') {
            $html .= $this->renderPerPageSelector();
        }

        // Page info (before navigation)
        if ($this->showInfo && $this->alignment === 'between') {
            $html .= $this->renderPageInfo();
        }

        // Navigation
        $html .= $this->renderNavigation();

        // Jump to page (after navigation)
        if ($this->showJumpToPage && $this->alignment === 'between') {
            $html .= $this->renderJumpToPage();
        }

        // Standalone info (if not between layout)
        if ($this->showInfo && $this->alignment !== 'between') {
            $html .= $this->renderPageInfo();
        }

        return $html;
    }

    /**
     * Render navigation
     *
     * @return string
     */
    protected function renderNavigation(): string
    {
        $html = '<ul class="' . CssPrefix::cls('pagination-nav') . '">';

        // First button
        if ($this->showFirstLast) {
            $disabled = $this->currentPage <= 1;
            $html .= $this->renderPageItem(
                $this->useIcons ? '<span class="material-icons">first_page</span>' : $this->labels['first'],
                1,
                $disabled,
                false,
                $this->labels['first']
            );
        }

        // Previous button
        if ($this->showPrevNext) {
            $disabled = $this->currentPage <= 1;
            $html .= $this->renderPageItem(
                $this->useIcons ? '<span class="material-icons">chevron_left</span>' : $this->labels['previous'],
                $this->currentPage - 1,
                $disabled,
                false,
                $this->labels['previous']
            );
        }

        // Page numbers (unless simple mode)
        if (!$this->simpleMode) {
            $pages = $this->calculateVisiblePages();
            foreach ($pages as $page) {
                if ($page === '...') {
                    $html .= '<li class="' . CssPrefix::cls('page-ellipsis') . '">...</li>';
                } else {
                    $active = $page === $this->currentPage;
                    $html .= $this->renderPageItem((string) $page, $page, false, $active);
                }
            }
        }

        // Next button
        if ($this->showPrevNext) {
            $disabled = $this->currentPage >= $this->totalPages;
            $html .= $this->renderPageItem(
                $this->useIcons ? '<span class="material-icons">chevron_right</span>' : $this->labels['next'],
                $this->currentPage + 1,
                $disabled,
                false,
                $this->labels['next']
            );
        }

        // Last button
        if ($this->showFirstLast) {
            $disabled = $this->currentPage >= $this->totalPages;
            $html .= $this->renderPageItem(
                $this->useIcons ? '<span class="material-icons">last_page</span>' : $this->labels['last'],
                $this->totalPages,
                $disabled,
                false,
                $this->labels['last']
            );
        }

        $html .= '</ul>';

        return $html;
    }

    /**
     * Render single page item
     *
     * @param string $content
     * @param int $page
     * @param bool $disabled
     * @param bool $active
     * @param string|null $ariaLabel
     * @return string
     */
    protected function renderPageItem(string $content, int $page, bool $disabled, bool $active, ?string $ariaLabel = null): string
    {
        $itemClass = CssPrefix::cls('page-item');
        if ($disabled) {
            $itemClass .= ' ' . CssPrefix::cls('disabled');
        }
        if ($active) {
            $itemClass .= ' ' . CssPrefix::cls('active');
        }

        $html = '<li class="' . $itemClass . '">';

        $linkClass = CssPrefix::cls('page-link');

        if ($disabled) {
            $html .= '<a class="' . $linkClass . '" href="#" aria-disabled="true" tabindex="-1"';
            if ($ariaLabel) {
                $html .= ' aria-label="' . e($ariaLabel) . '"';
            }
            $html .= '>' . $content . '</a>';
        } else {
            $html .= '<a class="' . $linkClass . '" href="' . e($this->getPageUrl($page)) . '"';
            if ($ariaLabel) {
                $html .= ' aria-label="' . e($ariaLabel) . '"';
            }
            if ($active) {
                $html .= ' aria-current="page"';
            }
            $html .= '>' . $content . '</a>';
        }

        $html .= '</li>';

        return $html;
    }

    /**
     * Render page info text
     *
     * @return string
     */
    protected function renderPageInfo(): string
    {
        if ($this->totalItems === null) {
            return '';
        }

        $start = ($this->currentPage - 1) * $this->itemsPerPage + 1;
        $end = min($this->currentPage * $this->itemsPerPage, $this->totalItems);

        if ($this->infoTemplate !== null) {
            $text = str_replace(
                ['{start}', '{end}', '{total}'],
                [$start, $end, $this->totalItems],
                $this->infoTemplate
            );
        } else {
            $text = 'Showing <strong>' . $start . '-' . $end . '</strong> of <strong>' . $this->totalItems . '</strong> results';
        }

        return '<span class="' . CssPrefix::cls('pagination-info') . '">' . $text . '</span>';
    }

    /**
     * Render per-page selector
     *
     * @return string
     */
    protected function renderPerPageSelector(): string
    {
        $html = '<div class="' . CssPrefix::cls('pagination-per-page') . '">';
        $html .= '<span class="' . CssPrefix::cls('pagination-label') . '">Rows per page:</span>';
        $html .= '<select class="' . CssPrefix::cls('pagination-select') . '">';

        foreach ($this->perPageOptions as $option) {
            $selected = $option === $this->itemsPerPage ? ' selected' : '';
            $html .= '<option value="' . $option . '"' . $selected . '>' . $option . '</option>';
        }

        $html .= '</select>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Render jump to page input
     *
     * @return string
     */
    protected function renderJumpToPage(): string
    {
        $html = '<div class="' . CssPrefix::cls('pagination-jump') . '">';
        $html .= '<span class="' . CssPrefix::cls('pagination-jump-label') . '">Go to page:</span>';
        $html .= '<input type="number" class="' . CssPrefix::cls('pagination-jump-input') . '" ';
        $html .= 'min="1" max="' . $this->totalPages . '" value="' . $this->currentPage . '">';
        $html .= '<button class="' . CssPrefix::cls('pagination-jump-btn') . '">Go</button>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Calculate which page numbers to show
     *
     * @return array
     */
    protected function calculateVisiblePages(): array
    {
        if ($this->totalPages <= $this->maxVisible) {
            return range(1, $this->totalPages);
        }

        $pages = [];
        $half = floor(($this->maxVisible - 2) / 2);

        $start = max(2, $this->currentPage - $half);
        $end = min($this->totalPages - 1, $this->currentPage + $half);

        // Adjust if at edges
        if ($this->currentPage <= $half + 1) {
            $end = min($this->maxVisible - 1, $this->totalPages - 1);
        }
        if ($this->currentPage >= $this->totalPages - $half) {
            $start = max(2, $this->totalPages - $this->maxVisible + 2);
        }

        // Always show first page
        $pages[] = 1;

        // Add ellipsis if needed
        if ($start > 2) {
            $pages[] = '...';
        }

        // Add middle pages
        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }

        // Add ellipsis if needed
        if ($end < $this->totalPages - 1) {
            $pages[] = '...';
        }

        // Always show last page
        if ($this->totalPages > 1) {
            $pages[] = $this->totalPages;
        }

        return $pages;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();

        $config['currentPage'] = $this->currentPage;
        $config['totalPages'] = $this->totalPages;

        if ($this->totalItems !== null) {
            $config['totalItems'] = $this->totalItems;
        }

        if ($this->itemsPerPage !== 10) {
            $config['itemsPerPage'] = $this->itemsPerPage;
        }

        if ($this->baseUrl !== '?page=') {
            $config['baseUrl'] = $this->baseUrl;
        }

        if (!$this->showPrevNext) {
            $config['showPrevNext'] = false;
        }

        if ($this->showFirstLast) {
            $config['showFirstLast'] = true;
        }

        if ($this->maxVisible !== 5) {
            $config['maxVisible'] = $this->maxVisible;
        }

        if ($this->size !== null) {
            $config['size'] = $this->size;
        }

        if ($this->variant !== null) {
            $config['variant'] = $this->variant;
        }

        if ($this->color !== null) {
            $config['color'] = $this->color;
        }

        if ($this->alignment !== 'start') {
            $config['alignment'] = $this->alignment;
        }

        if ($this->showInfo) {
            $config['showInfo'] = true;
            if ($this->infoTemplate !== null) {
                $config['infoTemplate'] = $this->infoTemplate;
            }
        }

        if ($this->showPerPageSelector) {
            $config['showPerPageSelector'] = true;
            $config['perPageOptions'] = $this->perPageOptions;
        }

        if ($this->showJumpToPage) {
            $config['showJumpToPage'] = true;
        }

        if ($this->simpleMode) {
            $config['simpleMode'] = true;
        }

        if (!$this->useIcons) {
            $config['useIcons'] = false;
        }

        return $config;
    }
}
