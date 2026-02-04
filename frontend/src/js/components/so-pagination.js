// ============================================
// SIXORBIT UI - PAGINATION COMPONENT
// Page navigation with Material Design features
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOPagination - Pagination navigation component
 * Supports page numbers, per-page selector, and jump to page
 */
class SOPagination extends SOComponent {
  static NAME = 'pagination';

  static DEFAULTS = {
    currentPage: 1,
    totalItems: 0,
    itemsPerPage: 10,
    itemsPerPageOptions: [10, 25, 50, 100],
    maxVisiblePages: 5,          // Max page numbers to show
    showFirstLast: true,         // Show first/last buttons
    showPrevNext: true,          // Show prev/next buttons
    showPageNumbers: true,       // Show page number buttons
    showPageInfo: false,         // Show "Showing X-Y of Z"
    showPerPageSelect: false,    // Show items per page selector
    showJumpToPage: false,       // Show "Go to page" input
    pageInfoTemplate: 'Showing {start}-{end} of {total}',
    perPageLabel: 'Rows per page:',
    jumpLabel: 'Go to page:',
    jumpButtonText: 'Go',
    firstIcon: 'first_page',
    prevIcon: 'chevron_left',
    nextIcon: 'chevron_right',
    lastIcon: 'last_page',
    ariaLabel: 'Pagination navigation',
    onChange: null,              // Callback when page changes
    onPerPageChange: null,       // Callback when items per page changes
  };

  static EVENTS = {
    PAGE_CHANGE: 'pagination:change',
    PER_PAGE_CHANGE: 'pagination:perpagechange',
  };

  // ============================================
  // INITIALIZATION
  // ============================================

  /**
   * Initialize the pagination component
   * @private
   */
  _init() {
    this._cacheElements();
    this._parseExistingStructure();
    this._bindEvents();
    this._render();
  }

  /**
   * Cache DOM elements
   * @private
   */
  _cacheElements() {
    this._nav = this.$('.so-pagination-nav');
    this._pageInfo = this.$('.so-pagination-info');
    this._perPageSelect = this.$('.so-pagination-select');
    this._jumpInput = this.$('.so-pagination-jump-input');
    this._jumpBtn = this.$('.so-pagination-jump-btn');
  }

  /**
   * Parse existing structure to get current state
   * @private
   */
  _parseExistingStructure() {
    // Try to get current page from active item
    const activeItem = this.$('.so-page-item.so-active .so-page-link');
    if (activeItem) {
      const page = parseInt(activeItem.textContent, 10);
      if (!isNaN(page)) {
        this.options.currentPage = page;
      }
    }

    // Try to get total from data attribute
    if (this.element.dataset.totalItems) {
      this.options.totalItems = parseInt(this.element.dataset.totalItems, 10);
    }

    if (this.element.dataset.itemsPerPage) {
      this.options.itemsPerPage = parseInt(this.element.dataset.itemsPerPage, 10);
    }
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Page link clicks
    this.delegate('click', '.so-page-link', this._handlePageClick);

    // Per page select change
    if (this._perPageSelect) {
      this.on('change', this._handlePerPageChange, this._perPageSelect);
    }

    // Jump to page
    if (this._jumpInput) {
      this.on('keydown', this._handleJumpKeydown, this._jumpInput);
    }

    if (this._jumpBtn) {
      this.on('click', this._handleJumpClick, this._jumpBtn);
    }

    // Keyboard navigation
    this.on('keydown', this._handleKeydown);
  }

  // ============================================
  // EVENT HANDLERS
  // ============================================

  /**
   * Handle page link click
   * @param {Event} e - Click event
   * @param {Element} link - Page link element
   * @private
   */
  _handlePageClick(e, link) {
    e.preventDefault();

    const item = link.closest('.so-page-item');
    if (item && item.classList.contains('so-disabled')) return;

    const action = link.dataset.page;

    switch (action) {
      case 'first':
        this.firstPage();
        break;
      case 'prev':
        this.prevPage();
        break;
      case 'next':
        this.nextPage();
        break;
      case 'last':
        this.lastPage();
        break;
      default:
        const page = parseInt(action, 10);
        if (!isNaN(page)) {
          this.goToPage(page);
        }
    }
  }

  /**
   * Handle per page select change
   * @param {Event} e - Change event
   * @private
   */
  _handlePerPageChange(e) {
    const perPage = parseInt(e.target.value, 10);
    if (!isNaN(perPage)) {
      this.setItemsPerPage(perPage);
    }
  }

  /**
   * Handle jump input keydown
   * @param {Event} e - Keydown event
   * @private
   */
  _handleJumpKeydown(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      this._executeJump();
    }
  }

  /**
   * Handle jump button click
   * @param {Event} e - Click event
   * @private
   */
  _handleJumpClick(e) {
    this._executeJump();
  }

  /**
   * Execute jump to page
   * @private
   */
  _executeJump() {
    if (!this._jumpInput) return;

    const page = parseInt(this._jumpInput.value, 10);
    if (!isNaN(page) && page >= 1 && page <= this.getTotalPages()) {
      this.goToPage(page);
      this._jumpInput.value = '';
    }
  }

  /**
   * Handle keyboard navigation
   * @param {Event} e - Keydown event
   * @private
   */
  _handleKeydown(e) {
    // Only handle if focus is within pagination nav
    if (!this._nav || !this._nav.contains(document.activeElement)) return;

    switch (e.key) {
      case 'ArrowLeft':
        e.preventDefault();
        this._focusPrevPage();
        break;
      case 'ArrowRight':
        e.preventDefault();
        this._focusNextPage();
        break;
      case 'Home':
        e.preventDefault();
        this._focusFirstPage();
        break;
      case 'End':
        e.preventDefault();
        this._focusLastPage();
        break;
    }
  }

  /**
   * Focus previous page button
   * @private
   */
  _focusPrevPage() {
    const items = this._nav.querySelectorAll('.so-page-item:not(.so-disabled) .so-page-link');
    const current = Array.from(items).indexOf(document.activeElement);
    if (current > 0) {
      items[current - 1].focus();
    }
  }

  /**
   * Focus next page button
   * @private
   */
  _focusNextPage() {
    const items = this._nav.querySelectorAll('.so-page-item:not(.so-disabled) .so-page-link');
    const current = Array.from(items).indexOf(document.activeElement);
    if (current < items.length - 1) {
      items[current + 1].focus();
    }
  }

  /**
   * Focus first page button
   * @private
   */
  _focusFirstPage() {
    const first = this._nav.querySelector('.so-page-item:not(.so-disabled) .so-page-link');
    if (first) first.focus();
  }

  /**
   * Focus last page button
   * @private
   */
  _focusLastPage() {
    const items = this._nav.querySelectorAll('.so-page-item:not(.so-disabled) .so-page-link');
    if (items.length) items[items.length - 1].focus();
  }

  // ============================================
  // NAVIGATION METHODS
  // ============================================

  /**
   * Go to a specific page
   * @param {number} page - Page number
   */
  goToPage(page) {
    const totalPages = this.getTotalPages();
    const newPage = Math.max(1, Math.min(page, totalPages));

    if (newPage === this.options.currentPage) return;

    const prevPage = this.options.currentPage;
    this.options.currentPage = newPage;

    this._render();
    this._emitChange(prevPage);
  }

  /**
   * Go to next page
   */
  nextPage() {
    this.goToPage(this.options.currentPage + 1);
  }

  /**
   * Go to previous page
   */
  prevPage() {
    this.goToPage(this.options.currentPage - 1);
  }

  /**
   * Go to first page
   */
  firstPage() {
    this.goToPage(1);
  }

  /**
   * Go to last page
   */
  lastPage() {
    this.goToPage(this.getTotalPages());
  }

  /**
   * Emit page change event
   * @param {number} prevPage - Previous page number
   * @private
   */
  _emitChange(prevPage) {
    const detail = {
      page: this.options.currentPage,
      previousPage: prevPage,
      totalPages: this.getTotalPages(),
      itemsPerPage: this.options.itemsPerPage,
      ...this.getPageRange(),
    };

    this.emit(SOPagination.EVENTS.PAGE_CHANGE, detail);

    if (typeof this.options.onChange === 'function') {
      this.options.onChange(detail);
    }
  }

  // ============================================
  // ITEMS PER PAGE
  // ============================================

  /**
   * Set items per page
   * @param {number} count - Items per page
   */
  setItemsPerPage(count) {
    if (count === this.options.itemsPerPage) return;

    const prevPerPage = this.options.itemsPerPage;
    this.options.itemsPerPage = count;

    // Adjust current page if necessary
    const totalPages = this.getTotalPages();
    if (this.options.currentPage > totalPages) {
      this.options.currentPage = Math.max(1, totalPages);
    }

    // Update select if exists
    if (this._perPageSelect) {
      this._perPageSelect.value = count;
    }

    this._render();

    const detail = {
      itemsPerPage: count,
      previousItemsPerPage: prevPerPage,
      currentPage: this.options.currentPage,
      totalPages: this.getTotalPages(),
    };

    this.emit(SOPagination.EVENTS.PER_PAGE_CHANGE, detail);

    if (typeof this.options.onPerPageChange === 'function') {
      this.options.onPerPageChange(detail);
    }
  }

  /**
   * Set total items
   * @param {number} total - Total items
   */
  setTotalItems(total) {
    this.options.totalItems = total;

    // Adjust current page if necessary
    const totalPages = this.getTotalPages();
    if (this.options.currentPage > totalPages) {
      this.options.currentPage = Math.max(1, totalPages);
    }

    this._render();
  }

  // ============================================
  // GETTERS
  // ============================================

  /**
   * Get current page number
   * @returns {number} Current page
   */
  getCurrentPage() {
    return this.options.currentPage;
  }

  /**
   * Get total number of pages
   * @returns {number} Total pages
   */
  getTotalPages() {
    if (this.options.totalItems === 0) return 1;
    return Math.ceil(this.options.totalItems / this.options.itemsPerPage);
  }

  /**
   * Get page range (start and end item numbers)
   * @returns {Object} {start, end, total}
   */
  getPageRange() {
    const start = (this.options.currentPage - 1) * this.options.itemsPerPage + 1;
    const end = Math.min(
      this.options.currentPage * this.options.itemsPerPage,
      this.options.totalItems
    );

    return {
      start: this.options.totalItems > 0 ? start : 0,
      end,
      total: this.options.totalItems,
    };
  }

  // ============================================
  // RENDERING
  // ============================================

  /**
   * Render pagination
   * @private
   */
  _render() {
    this._renderNav();
    this._renderPageInfo();
    this._updatePerPageSelect();
  }

  /**
   * Render navigation
   * @private
   */
  _renderNav() {
    if (!this._nav) return;

    const totalPages = this.getTotalPages();
    const currentPage = this.options.currentPage;
    const html = [];

    // First button
    if (this.options.showFirstLast) {
      html.push(this._renderPageItem('first', this.options.firstIcon, currentPage === 1));
    }

    // Previous button
    if (this.options.showPrevNext) {
      html.push(this._renderPageItem('prev', this.options.prevIcon, currentPage === 1));
    }

    // Page numbers
    if (this.options.showPageNumbers) {
      const pages = this._getVisiblePages();
      let prevPage = 0;

      pages.forEach(page => {
        // Add ellipsis if there's a gap
        if (page - prevPage > 1) {
          html.push('<li class="so-page-ellipsis">...</li>');
        }

        html.push(this._renderPageItem(page, page.toString(), false, page === currentPage));
        prevPage = page;
      });
    }

    // Next button
    if (this.options.showPrevNext) {
      html.push(this._renderPageItem('next', this.options.nextIcon, currentPage === totalPages));
    }

    // Last button
    if (this.options.showFirstLast) {
      html.push(this._renderPageItem('last', this.options.lastIcon, currentPage === totalPages));
    }

    this._nav.innerHTML = html.join('');
  }

  /**
   * Render a page item
   * @param {string|number} page - Page identifier
   * @param {string} content - Button content
   * @param {boolean} disabled - Whether disabled
   * @param {boolean} active - Whether active
   * @returns {string} HTML string
   * @private
   */
  _renderPageItem(page, content, disabled = false, active = false) {
    const disabledClass = disabled ? ' so-disabled' : '';
    const activeClass = active ? ' so-active' : '';
    const isIcon = ['first', 'prev', 'next', 'last'].includes(page);
    const ariaCurrent = active ? ' aria-current="page"' : '';
    const ariaDisabled = disabled ? ' aria-disabled="true"' : '';
    const tabindex = disabled ? ' tabindex="-1"' : '';

    const contentHtml = isIcon
      ? `<span class="material-icons">${content}</span>`
      : content;

    return `
      <li class="so-page-item${disabledClass}${activeClass}">
        <a href="#" class="so-page-link" data-page="${page}"${ariaCurrent}${ariaDisabled}${tabindex}>
          ${contentHtml}
        </a>
      </li>
    `;
  }

  /**
   * Get array of visible page numbers
   * @returns {Array<number>} Page numbers
   * @private
   */
  _getVisiblePages() {
    const totalPages = this.getTotalPages();
    const currentPage = this.options.currentPage;
    const maxVisible = this.options.maxVisiblePages;

    if (totalPages <= maxVisible) {
      return Array.from({ length: totalPages }, (_, i) => i + 1);
    }

    const pages = [];
    const halfVisible = Math.floor(maxVisible / 2);

    // Always show first page
    pages.push(1);

    // Calculate range around current page
    let start = Math.max(2, currentPage - halfVisible);
    let end = Math.min(totalPages - 1, currentPage + halfVisible);

    // Adjust if near the start
    if (currentPage <= halfVisible + 1) {
      end = Math.min(totalPages - 1, maxVisible - 1);
    }

    // Adjust if near the end
    if (currentPage >= totalPages - halfVisible) {
      start = Math.max(2, totalPages - maxVisible + 2);
    }

    // Add range
    for (let i = start; i <= end; i++) {
      pages.push(i);
    }

    // Always show last page
    if (totalPages > 1) {
      pages.push(totalPages);
    }

    return pages;
  }

  /**
   * Render page info
   * @private
   */
  _renderPageInfo() {
    if (!this._pageInfo) return;

    const { start, end, total } = this.getPageRange();
    const text = this.options.pageInfoTemplate
      .replace('{start}', start)
      .replace('{end}', end)
      .replace('{total}', total);

    this._pageInfo.innerHTML = text;
  }

  /**
   * Update per page select value
   * @private
   */
  _updatePerPageSelect() {
    if (!this._perPageSelect) return;
    this._perPageSelect.value = this.options.itemsPerPage;
  }

  /**
   * Refresh pagination
   */
  refresh() {
    this._render();
  }

  // ============================================
  // STATIC METHODS
  // ============================================

  /**
   * Get or create instance
   * @param {Element|string} element - Element or selector
   * @param {Object} [options] - Options
   * @returns {SOPagination} Instance
   */
  static getInstance(element, options = {}) {
    const el = typeof element === 'string'
      ? document.querySelector(element)
      : element;

    return SixOrbit.getInstance(el, this.NAME, options);
  }

  /**
   * Initialize all pagination components on page
   * @param {string} [selector] - Custom selector
   * @param {Object} [options] - Default options
   * @returns {Array<SOPagination>} Array of instances
   */
  static initAll(selector, options = {}) {
    const sel = selector || SixOrbit.dataSel(this.NAME);
    const elements = document.querySelectorAll(sel);

    return Array.from(elements).map(el => this.getInstance(el, options));
  }

  /**
   * Create pagination programmatically
   * @param {Object} options - Options
   * @returns {SOPagination} Instance
   */
  static create(options = {}) {
    const container = document.createElement('nav');
    container.className = 'so-pagination';
    container.setAttribute('aria-label', options.ariaLabel || SOPagination.DEFAULTS.ariaLabel);

    // Build structure based on options
    let html = '';

    // Page info
    if (options.showPageInfo) {
      html += '<span class="so-pagination-info"></span>';
    }

    // Per page selector
    if (options.showPerPageSelect) {
      const perPageOptions = (options.itemsPerPageOptions || SOPagination.DEFAULTS.itemsPerPageOptions)
        .map(n => `<option value="${n}">${n}</option>`)
        .join('');

      html += `
        <div class="so-pagination-per-page">
          <span class="so-pagination-label">${options.perPageLabel || SOPagination.DEFAULTS.perPageLabel}</span>
          <select class="so-pagination-select">${perPageOptions}</select>
        </div>
      `;
    }

    // Navigation
    html += '<ul class="so-pagination-nav"></ul>';

    // Jump to page
    if (options.showJumpToPage) {
      html += `
        <div class="so-pagination-jump">
          <span class="so-pagination-jump-label">${options.jumpLabel || SOPagination.DEFAULTS.jumpLabel}</span>
          <input type="number" class="so-pagination-jump-input" min="1">
          <button type="button" class="so-pagination-jump-btn">${options.jumpButtonText || SOPagination.DEFAULTS.jumpButtonText}</button>
        </div>
      `;
    }

    container.innerHTML = html;

    // Create instance
    const instance = new SOPagination(container, options);

    return instance;
  }
}

// Register component
SOPagination.register = function() {
  SixOrbit.registerComponent(this.NAME, this);
};

// Auto-register
SOPagination.register();

// Export
window.SOPagination = SOPagination;
export default SOPagination;
