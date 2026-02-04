// ============================================
// SIXORBIT UI ENGINE - PAGINATION ELEMENT
// Page navigation with interactive controls
// ============================================

import { Element } from '../../core/Element.js';
import SixOrbit from '../../../core/so-config.js';

class Pagination extends Element {
    static NAME = 'ui-pagination';
    static DEFAULTS = {
        ...Element.DEFAULTS,
        type: 'pagination',
        tagName: 'nav'
    };

    // Instance registry for getInstance
    static instances = new Map();

    _initFromConfig(config) {
        super._initFromConfig(config);

        // Core pagination properties
        this._currentPage = config.currentPage || 1;
        this._totalPages = config.totalPages || 1;
        this._totalItems = config.totalItems || null;
        this._itemsPerPage = config.itemsPerPage || 10;

        // Calculate totalPages from totalItems if provided
        if (this._totalItems !== null && this._itemsPerPage > 0) {
            this._totalPages = Math.ceil(this._totalItems / this._itemsPerPage);
        }

        // URL configuration
        this._baseUrl = config.baseUrl || '#';
        this._pageParam = config.pageParam || 'page';

        // Display options
        this._showPrevNext = config.showPrevNext !== false;
        this._showFirstLast = config.showFirstLast || false;
        this._maxVisible = config.maxVisible || 5;

        // Styling
        this._size = config.size || null;
        this._variant = config.variant || null;
        this._color = config.color || null;
        this._alignment = config.alignment || 'start';

        // Advanced features
        this._showInfo = config.showInfo || false;
        this._infoTemplate = config.infoTemplate || null;
        this._showPerPageSelector = config.showPerPageSelector || false;
        this._perPageOptions = config.perPageOptions || [10, 25, 50, 100];
        this._showJumpToPage = config.showJumpToPage || false;
        this._simpleMode = config.simpleMode || false;
        this._useIcons = config.useIcons !== false;

        // Labels
        this._labels = {
            first: 'First',
            last: 'Last',
            previous: 'Previous',
            next: 'Next',
            ...(config.labels || {})
        };

        // Event callbacks
        this._onPageChange = config.onPageChange || null;
        this._onPerPageChange = config.onPerPageChange || null;
    }

    // ========================================
    // CONFIGURATION METHODS
    // ========================================

    currentPage(page) {
        this._currentPage = page;
        return this;
    }

    totalPages(pages) {
        this._totalPages = pages;
        return this;
    }

    fromTotal(totalItems, itemsPerPage = 10) {
        this._totalItems = totalItems;
        this._itemsPerPage = itemsPerPage;
        this._totalPages = Math.ceil(totalItems / itemsPerPage);
        return this;
    }

    itemsPerPage(items) {
        this._itemsPerPage = items;
        if (this._totalItems !== null) {
            this._totalPages = Math.ceil(this._totalItems / this._itemsPerPage);
        }
        return this;
    }

    baseUrl(url) {
        this._baseUrl = url;
        return this;
    }

    pageParam(param) {
        this._pageParam = param;
        return this;
    }

    showPrevNext(show = true) {
        this._showPrevNext = show;
        return this;
    }

    showFirstLast(show = true) {
        this._showFirstLast = show;
        return this;
    }

    maxVisible(max) {
        this._maxVisible = max;
        return this;
    }

    size(s) {
        this._size = s;
        return this;
    }

    small() {
        return this.size('sm');
    }

    large() {
        return this.size('lg');
    }

    variant(v) {
        this._variant = v;
        return this;
    }

    rounded() {
        return this.variant('rounded');
    }

    outlined() {
        return this.variant('outlined');
    }

    minimal() {
        return this.variant('minimal');
    }

    color(c) {
        this._color = c;
        return this;
    }

    primary() {
        return this.color('primary');
    }

    success() {
        return this.color('success');
    }

    danger() {
        return this.color('danger');
    }

    alignment(a) {
        this._alignment = a;
        return this;
    }

    center() {
        return this.alignment('center');
    }

    end() {
        return this.alignment('end');
    }

    between() {
        return this.alignment('between');
    }

    showInfo(show = true, template = null) {
        this._showInfo = show;
        if (template !== null) {
            this._infoTemplate = template;
        }
        return this;
    }

    showPerPageSelector(show = true, options = null) {
        this._showPerPageSelector = show;
        if (options !== null) {
            this._perPageOptions = options;
        }
        return this;
    }

    showJumpToPage(show = true) {
        this._showJumpToPage = show;
        return this;
    }

    simple(isSimple = true) {
        this._simpleMode = isSimple;
        return this;
    }

    useIcons(use = true) {
        this._useIcons = use;
        return this;
    }

    labels(lbls) {
        this._labels = { ...this._labels, ...lbls };
        return this;
    }

    // ========================================
    // EVENT HANDLING
    // ========================================

    onPageChange(callback) {
        this._onPageChange = callback;
        return this;
    }

    onPerPageChange(callback) {
        this._onPerPageChange = callback;
        return this;
    }

    _dispatchPageChangeEvent(oldPage, newPage) {
        const detail = {
            oldPage,
            newPage,
            page: newPage,
            totalPages: this._totalPages,
            range: this.getPageRange()
        };

        this._dispatchEvent('so:pagination:change', detail);

        if (this._onPageChange) {
            this._onPageChange(newPage, detail);
        }
    }

    _dispatchPerPageChangeEvent(oldPerPage, newPerPage) {
        const detail = {
            oldPerPage,
            newPerPage,
            perPage: newPerPage,
            currentPage: this._currentPage
        };

        this._dispatchEvent('so:pagination:perpage:change', detail);

        if (this._onPerPageChange) {
            this._onPerPageChange(newPerPage, detail);
        }
    }

    // ========================================
    // INTERACTIVE METHODS (NAVIGATION)
    // ========================================

    goToPage(page) {
        if (page < 1 || page > this._totalPages || page === this._currentPage) {
            return this;
        }

        const oldPage = this._currentPage;
        this._currentPage = page;

        if (this._element) {
            this._updateDOM();
        }

        this._dispatchPageChangeEvent(oldPage, page);
        return this;
    }

    nextPage() {
        return this.goToPage(this._currentPage + 1);
    }

    prevPage() {
        return this.goToPage(this._currentPage - 1);
    }

    firstPage() {
        return this.goToPage(1);
    }

    lastPage() {
        return this.goToPage(this._totalPages);
    }

    setPerPage(perPage) {
        if (!this._perPageOptions.includes(perPage)) {
            return this;
        }

        const oldPerPage = this._itemsPerPage;
        this._itemsPerPage = perPage;

        if (this._totalItems !== null) {
            this._totalPages = Math.ceil(this._totalItems / this._itemsPerPage);

            // Adjust current page if necessary
            if (this._currentPage > this._totalPages) {
                this._currentPage = this._totalPages;
            }
        }

        if (this._element) {
            this._updateDOM();
        }

        this._dispatchPerPageChangeEvent(oldPerPage, perPage);
        return this;
    }

    // ========================================
    // QUERY METHODS
    // ========================================

    getCurrentPage() {
        return this._currentPage;
    }

    getTotalPages() {
        return this._totalPages;
    }

    getItemsPerPage() {
        return this._itemsPerPage;
    }

    getPageRange() {
        if (this._totalItems === null) {
            return null;
        }

        const start = (this._currentPage - 1) * this._itemsPerPage + 1;
        const end = Math.min(this._currentPage * this._itemsPerPage, this._totalItems);

        return {
            start,
            end,
            total: this._totalItems
        };
    }

    hasNextPage() {
        return this._currentPage < this._totalPages;
    }

    hasPrevPage() {
        return this._currentPage > 1;
    }

    // ========================================
    // DYNAMIC CLASS/ATTRIBUTE METHODS
    // ========================================

    updateSize(size) {
        if (this._element) {
            if (this._size) {
                this._element.classList.remove(SixOrbit.cls('pagination', this._size));
            }
            this._size = size;
            if (this._size) {
                this._element.classList.add(SixOrbit.cls('pagination', this._size));
            }
        } else {
            this._size = size;
        }
        return this;
    }

    updateVariant(variant) {
        if (this._element) {
            if (this._variant) {
                this._element.classList.remove(SixOrbit.cls('pagination', this._variant));
            }
            this._variant = variant;
            if (this._variant) {
                this._element.classList.add(SixOrbit.cls('pagination', this._variant));
            }
        } else {
            this._variant = variant;
        }
        return this;
    }

    updateColor(color) {
        if (this._element) {
            if (this._color) {
                this._element.classList.remove(SixOrbit.cls('pagination', this._color));
            }
            this._color = color;
            if (this._color) {
                this._element.classList.add(SixOrbit.cls('pagination', this._color));
            }
        } else {
            this._color = color;
        }
        return this;
    }

    updateAlignment(alignment) {
        if (this._element) {
            const oldClass = SixOrbit.cls('pagination', this._alignment);
            this._element.classList.remove(oldClass);
            this._alignment = alignment;
            if (this._alignment !== 'start') {
                this._element.classList.add(SixOrbit.cls('pagination', this._alignment));
            }
        } else {
            this._alignment = alignment;
        }
        return this;
    }

    // ========================================
    // DOM UPDATE
    // ========================================

    _updateDOM() {
        if (!this._element) return;

        // Update data attributes
        this._element.setAttribute(SixOrbit.data('current-page'), this._currentPage);
        this._element.setAttribute(SixOrbit.data('total-pages'), this._totalPages);

        // Re-render content
        this._element.innerHTML = this.renderContent();

        // Re-attach event listeners
        this._attachEventListeners();
    }

    // ========================================
    // RENDERING
    // ========================================

    buildClassString() {
        let cls = SixOrbit.cls('pagination');

        if (this._size) cls += ` ${SixOrbit.cls('pagination', this._size)}`;
        if (this._variant) cls += ` ${SixOrbit.cls('pagination', this._variant)}`;
        if (this._color) cls += ` ${SixOrbit.cls('pagination', this._color)}`;
        if (this._alignment !== 'start') cls += ` ${SixOrbit.cls('pagination', this._alignment)}`;

        return cls + (this._classes ? ' ' + this._classes : '');
    }

    _gatherAttributes() {
        const attrs = super._gatherAttributes();

        attrs['aria-label'] = 'Page navigation';

        // Data attributes for configuration
        if (this._totalItems !== null) {
            attrs[SixOrbit.data('total-items')] = this._totalItems;
        }
        attrs[SixOrbit.data('items-per-page')] = this._itemsPerPage;
        attrs[SixOrbit.data('current-page')] = this._currentPage;
        attrs[SixOrbit.data('total-pages')] = this._totalPages;

        if (this._showInfo) {
            attrs[SixOrbit.data('show-page-info')] = 'true';
        }

        if (this._showFirstLast) {
            attrs[SixOrbit.data('show-first-last')] = 'true';
        }

        // Mark for auto-initialization
        attrs[SixOrbit.data('pagination')] = '';

        return attrs;
    }

    _buildPageUrl(page) {
        if (this._baseUrl === '#') {
            return '#';
        }

        try {
            const url = new URL(this._baseUrl, window.location.origin);
            url.searchParams.set(this._pageParam, page);
            return url.toString();
        } catch {
            return `${this._baseUrl}${this._pageParam}=${page}`;
        }
    }

    renderContent() {
        let html = '';

        // Per-page selector (before navigation)
        if (this._showPerPageSelector && this._alignment === 'between') {
            html += this._renderPerPageSelector();
        }

        // Page info (before navigation)
        if (this._showInfo && this._alignment === 'between') {
            html += this._renderPageInfo();
        }

        // Navigation
        html += this._renderNavigation();

        // Jump to page (after navigation)
        if (this._showJumpToPage && this._alignment === 'between') {
            html += this._renderJumpToPage();
        }

        // Standalone info (if not between layout)
        if (this._showInfo && this._alignment !== 'between') {
            html += this._renderPageInfo();
        }

        return html;
    }

    _renderNavigation() {
        let html = `<ul class="${SixOrbit.cls('pagination-nav')}">`;

        // First button
        if (this._showFirstLast) {
            const disabled = this._currentPage <= 1;
            const content = this._useIcons
                ? '<span class="material-icons">first_page</span>'
                : this._labels.first;
            html += this._renderPageItem(content, 1, disabled, false, this._labels.first);
        }

        // Previous button
        if (this._showPrevNext) {
            const disabled = this._currentPage <= 1;
            const content = this._useIcons
                ? '<span class="material-icons">chevron_left</span>'
                : this._labels.previous;
            html += this._renderPageItem(content, this._currentPage - 1, disabled, false, this._labels.previous);
        }

        // Page numbers (unless simple mode)
        if (!this._simpleMode) {
            const pages = this._getVisiblePages();
            pages.forEach(page => {
                if (page === '...') {
                    html += `<li class="${SixOrbit.cls('page-ellipsis')}">...</li>`;
                } else {
                    const active = page === this._currentPage;
                    html += this._renderPageItem(String(page), page, false, active);
                }
            });
        }

        // Next button
        if (this._showPrevNext) {
            const disabled = this._currentPage >= this._totalPages;
            const content = this._useIcons
                ? '<span class="material-icons">chevron_right</span>'
                : this._labels.next;
            html += this._renderPageItem(content, this._currentPage + 1, disabled, false, this._labels.next);
        }

        // Last button
        if (this._showFirstLast) {
            const disabled = this._currentPage >= this._totalPages;
            const content = this._useIcons
                ? '<span class="material-icons">last_page</span>'
                : this._labels.last;
            html += this._renderPageItem(content, this._totalPages, disabled, false, this._labels.last);
        }

        html += '</ul>';
        return html;
    }

    _renderPageItem(content, page, disabled = false, active = false, ariaLabel = null) {
        let itemClass = SixOrbit.cls('page-item');
        if (disabled) itemClass += ` ${SixOrbit.cls('disabled')}`;
        if (active) itemClass += ` ${SixOrbit.cls('active')}`;

        let html = `<li class="${itemClass}">`;

        const linkClass = SixOrbit.cls('page-link');

        if (disabled) {
            html += `<a class="${linkClass}" href="#" aria-disabled="true" tabindex="-1"`;
            if (ariaLabel) html += ` aria-label="${ariaLabel}"`;
            html += `>${content}</a>`;
        } else {
            html += `<a class="${linkClass}" href="${this._buildPageUrl(page)}" data-page="${page}"`;
            if (ariaLabel) html += ` aria-label="${ariaLabel}"`;
            if (active) html += ' aria-current="page"';
            html += `>${content}</a>`;
        }

        html += '</li>';
        return html;
    }

    _renderPageInfo() {
        if (this._totalItems === null) {
            return '';
        }

        const range = this.getPageRange();
        let text;

        if (this._infoTemplate) {
            text = this._infoTemplate
                .replace('{start}', range.start)
                .replace('{end}', range.end)
                .replace('{total}', range.total);
        } else {
            text = `Showing <strong>${range.start}-${range.end}</strong> of <strong>${range.total}</strong> results`;
        }

        return `<span class="${SixOrbit.cls('pagination-info')}">${text}</span>`;
    }

    _renderPerPageSelector() {
        let html = `<div class="${SixOrbit.cls('pagination-per-page')}">`;
        html += `<span class="${SixOrbit.cls('pagination-label')}">Rows per page:</span>`;
        html += `<select class="${SixOrbit.cls('pagination-select')}">`;

        this._perPageOptions.forEach(option => {
            const selected = option === this._itemsPerPage ? ' selected' : '';
            html += `<option value="${option}"${selected}>${option}</option>`;
        });

        html += '</select></div>';
        return html;
    }

    _renderJumpToPage() {
        let html = `<div class="${SixOrbit.cls('pagination-jump')}">`;
        html += `<span class="${SixOrbit.cls('pagination-jump-label')}">Go to page:</span>`;
        html += `<input type="number" class="${SixOrbit.cls('pagination-jump-input')}" `;
        html += `min="1" max="${this._totalPages}" value="${this._currentPage}">`;
        html += `<button class="${SixOrbit.cls('pagination-jump-btn')}">Go</button>`;
        html += '</div>';
        return html;
    }

    _getVisiblePages() {
        if (this._totalPages <= this._maxVisible) {
            return Array.from({ length: this._totalPages }, (_, i) => i + 1);
        }

        const pages = [];
        const half = Math.floor((this._maxVisible - 2) / 2);

        let start = Math.max(2, this._currentPage - half);
        let end = Math.min(this._totalPages - 1, this._currentPage + half);

        // Adjust if at edges
        if (this._currentPage <= half + 1) {
            end = Math.min(this._maxVisible - 1, this._totalPages - 1);
        }
        if (this._currentPage >= this._totalPages - half) {
            start = Math.max(2, this._totalPages - this._maxVisible + 2);
        }

        // Always show first page
        pages.push(1);

        // Add ellipsis if needed
        if (start > 2) {
            pages.push('...');
        }

        // Add middle pages
        for (let i = start; i <= end; i++) {
            pages.push(i);
        }

        // Add ellipsis if needed
        if (end < this._totalPages - 1) {
            pages.push('...');
        }

        // Always show last page
        if (this._totalPages > 1) {
            pages.push(this._totalPages);
        }

        return pages;
    }

    // ========================================
    // EVENT LISTENERS
    // ========================================

    _attachEventListeners() {
        if (!this._element) return;

        // Page link clicks
        this._element.querySelectorAll(`.${SixOrbit.cls('page-link')}[data-page]`).forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = parseInt(link.getAttribute('data-page'), 10);
                this.goToPage(page);
            });
        });

        // Per-page selector change
        const perPageSelect = this._element.querySelector(`.${SixOrbit.cls('pagination-select')}`);
        if (perPageSelect) {
            perPageSelect.addEventListener('change', (e) => {
                this.setPerPage(parseInt(e.target.value, 10));
            });
        }

        // Jump to page
        const jumpBtn = this._element.querySelector(`.${SixOrbit.cls('pagination-jump-btn')}`);
        const jumpInput = this._element.querySelector(`.${SixOrbit.cls('pagination-jump-input')}`);
        if (jumpBtn && jumpInput) {
            jumpBtn.addEventListener('click', () => {
                const page = parseInt(jumpInput.value, 10);
                if (!isNaN(page)) {
                    this.goToPage(page);
                }
            });

            jumpInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    const page = parseInt(jumpInput.value, 10);
                    if (!isNaN(page)) {
                        this.goToPage(page);
                    }
                }
            });
        }
    }

    // ========================================
    // LIFECYCLE
    // ========================================

    render() {
        const html = super.render();

        // After rendering, attach event listeners
        if (this._element) {
            this._attachEventListeners();

            // Register instance
            Pagination.instances.set(this._element, this);
        }

        return html;
    }

    destroy() {
        if (this._element) {
            Pagination.instances.delete(this._element);
        }
        super.destroy();
    }

    // ========================================
    // STATIC METHODS
    // ========================================

    static getInstance(element) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }

        if (!element) return null;

        // Check if already instantiated
        if (Pagination.instances.has(element)) {
            return Pagination.instances.get(element);
        }

        // Create from data attributes
        const config = {
            currentPage: parseInt(element.getAttribute(SixOrbit.data('current-page'))) || 1,
            totalPages: parseInt(element.getAttribute(SixOrbit.data('total-pages'))) || 1,
            totalItems: parseInt(element.getAttribute(SixOrbit.data('total-items'))) || null,
            itemsPerPage: parseInt(element.getAttribute(SixOrbit.data('items-per-page'))) || 10,
            showInfo: element.hasAttribute(SixOrbit.data('show-page-info')),
            showFirstLast: element.hasAttribute(SixOrbit.data('show-first-last'))
        };

        const instance = new Pagination(config);
        instance._element = element;
        instance._attachEventListeners();

        Pagination.instances.set(element, instance);
        return instance;
    }

    // Auto-initialize all pagination elements
    static initAll() {
        document.querySelectorAll(`[${SixOrbit.data('pagination')}]`).forEach(element => {
            if (!Pagination.instances.has(element)) {
                Pagination.getInstance(element);
            }
        });
    }

    toConfig() {
        const config = super.toConfig();

        config.currentPage = this._currentPage;
        config.totalPages = this._totalPages;
        if (this._totalItems !== null) config.totalItems = this._totalItems;
        if (this._itemsPerPage !== 10) config.itemsPerPage = this._itemsPerPage;
        if (this._baseUrl !== '#') config.baseUrl = this._baseUrl;
        if (this._pageParam !== 'page') config.pageParam = this._pageParam;
        if (!this._showPrevNext) config.showPrevNext = false;
        if (this._showFirstLast) config.showFirstLast = true;
        if (this._maxVisible !== 5) config.maxVisible = this._maxVisible;
        if (this._size) config.size = this._size;
        if (this._variant) config.variant = this._variant;
        if (this._color) config.color = this._color;
        if (this._alignment !== 'start') config.alignment = this._alignment;
        if (this._showInfo) config.showInfo = true;
        if (this._infoTemplate) config.infoTemplate = this._infoTemplate;
        if (this._showPerPageSelector) {
            config.showPerPageSelector = true;
            config.perPageOptions = this._perPageOptions;
        }
        if (this._showJumpToPage) config.showJumpToPage = true;
        if (this._simpleMode) config.simpleMode = true;
        if (!this._useIcons) config.useIcons = false;

        return config;
    }
}

// Auto-initialize on DOM ready
if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => Pagination.initAll());
    } else {
        Pagination.initAll();
    }
}

export default Pagination;
export { Pagination };
