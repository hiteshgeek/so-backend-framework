// ============================================
// SIXORBIT UI - SEARCH OVERLAY
// Global search functionality
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SOSearchOverlay - Global search overlay component
 */
class SOSearchOverlay extends SOComponent {
  static NAME = 'search';

  static DEFAULTS = {
    overlaySelector: '.so-search-overlay',
    inputSelector: '.so-search-overlay-input',
    closeSelector: '.so-search-overlay-close',
    backdropSelector: '.so-search-overlay-backdrop',
    quickLinksSelector: '.so-search-quick-link',
    categorySelector: '.so-search-category-tab',
    viewToggleSelector: '.so-search-view-btn',
    resultsSelector: '.so-search-results',
    emptySelector: '.so-search-empty',
    loadingSelector: '.so-search-loading',
    storageKey: 'search-history',
    maxHistory: 5,
    debounceMs: 200,
  };

  static EVENTS = {
    OPEN: 'search:open',
    CLOSE: 'search:close',
    SEARCH: 'search:search',
    SELECT: 'search:select',
  };

  /**
   * Initialize the search overlay
   * @private
   */
  _init() {
    // Cache elements
    this._overlay = document.querySelector(this.options.overlaySelector);
    this._input = this._overlay?.querySelector(this.options.inputSelector);
    this._closeBtn = this._overlay?.querySelector(this.options.closeSelector);
    this._results = this._overlay?.querySelector(this.options.resultsSelector);

    if (!this._overlay || !this._input) return;

    // State
    this._isOpen = false;
    this._currentCategory = 'all';
    this._viewMode = 'grid';
    this._searchHistory = this._loadHistory();
    this._debounceTimer = null;

    // Bind events
    this._bindEvents();

    // Store reference globally
    window.soSearchOverlay = this;
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Close button
    if (this._closeBtn) {
      this.on('click', () => this.close(), this._closeBtn);
    }

    // Backdrop click
    const backdrop = this._overlay.querySelector(this.options.backdropSelector);
    if (backdrop) {
      this.on('click', () => this.close(), backdrop);
    }

    // Escape key
    this.on('keydown', this._handleKeydown, document);

    // Search input
    this.on('input', this._handleInput, this._input);
    this.on('keydown', this._handleSearchKeydown, this._input);

    // Quick links
    this._overlay.querySelectorAll(this.options.quickLinksSelector).forEach(link => {
      this.on('click', this._handleQuickLinkClick, link);
    });

    // Category tabs
    this._overlay.querySelectorAll(this.options.categorySelector).forEach(tab => {
      this.on('click', this._handleCategoryClick, tab);
    });

    // View toggle
    this._overlay.querySelectorAll(this.options.viewToggleSelector).forEach(btn => {
      this.on('click', this._handleViewToggle, btn);
    });

    // Result clicks
    this.delegate('click', '.so-search-item-card, .so-search-item-row, .so-search-account-card', this._handleResultClick, this._overlay);

    // Prevent form submission
    const form = this._overlay.querySelector('form');
    if (form) {
      this.on('submit', (e) => e.preventDefault(), form);
    }
  }

  /**
   * Handle keyboard events
   * @param {KeyboardEvent} e - Keyboard event
   * @private
   */
  _handleKeydown(e) {
    // Open with Ctrl/Cmd + K
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
      e.preventDefault();
      this.toggle();
    }

    // Close with Escape
    if (e.key === 'Escape' && this._isOpen) {
      this.close();
    }
  }

  /**
   * Handle search input keydown
   * @param {KeyboardEvent} e - Keyboard event
   * @private
   */
  _handleSearchKeydown(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      this._performSearch(this._input.value);
    }
  }

  /**
   * Handle search input
   * @param {Event} e - Input event
   * @private
   */
  _handleInput(e) {
    const query = e.target.value.trim();

    // Clear previous debounce
    clearTimeout(this._debounceTimer);

    // Debounce search
    this._debounceTimer = setTimeout(() => {
      if (query.length >= 2) {
        this._performSearch(query);
      } else {
        this._showInitialState();
      }
    }, this.options.debounceMs);
  }

  /**
   * Handle quick link click
   * @param {Event} e - Click event
   * @private
   */
  _handleQuickLinkClick(e) {
    e.preventDefault();
    const link = e.currentTarget;
    const text = link.querySelector('.so-search-quick-link-text')?.textContent;

    if (text) {
      this._input.value = text;
      this._performSearch(text);
    }
  }

  /**
   * Handle category tab click
   * @param {Event} e - Click event
   * @private
   */
  _handleCategoryClick(e) {
    const tab = e.currentTarget;
    const category = tab.dataset.category;

    // Update active state
    this._overlay.querySelectorAll(this.options.categorySelector).forEach(t => {
      t.classList.toggle('so-active', t === tab);
    });

    this._currentCategory = category;

    // Re-filter results
    if (this._input.value.trim()) {
      this._performSearch(this._input.value);
    }
  }

  /**
   * Handle view toggle
   * @param {Event} e - Click event
   * @private
   */
  _handleViewToggle(e) {
    const btn = e.currentTarget;
    const view = btn.dataset.view;

    // Update button states
    this._overlay.querySelectorAll(this.options.viewToggleSelector).forEach(b => {
      b.classList.toggle('so-active', b === btn);
    });

    // Update results view
    const resultsGrid = this._overlay.querySelector('.so-search-results-grid');
    if (resultsGrid) {
      resultsGrid.classList.toggle('list-view', view === 'list');
    }

    this._viewMode = view;
  }

  /**
   * Handle result click
   * @param {Event} e - Click event
   * @param {Element} target - Clicked result element
   * @private
   */
  _handleResultClick(e, target) {
    const itemId = target.dataset.itemId;
    const itemType = target.dataset.itemType;

    this.emit(SOSearchOverlay.EVENTS.SELECT, {
      id: itemId,
      type: itemType,
      element: target,
    });

    // Add to history
    const title = target.querySelector('.so-search-item-name, .so-search-account-name')?.textContent;
    if (title) {
      this._addToHistory(this._input.value, title);
    }

    this.close();
  }

  /**
   * Perform search (to be implemented by user)
   * @param {string} query - Search query
   * @private
   */
  _performSearch(query) {
    this.emit(SOSearchOverlay.EVENTS.SEARCH, {
      query,
      category: this._currentCategory,
    });

    // Show loading state
    this._showLoading();
  }

  /**
   * Show loading state
   * @private
   */
  _showLoading() {
    const loader = this._overlay.querySelector('.so-search-loading');
    const results = this._overlay.querySelector('.so-search-results');
    const initial = this._overlay.querySelector('.so-search-initial');

    if (loader) loader.style.display = 'flex';
    if (results) results.style.display = 'none';
    if (initial) initial.style.display = 'none';
  }

  /**
   * Show search results
   * @param {Array} items - Search results
   */
  showResults(items) {
    const loader = this._overlay.querySelector('.so-search-loading');
    const results = this._overlay.querySelector('.so-search-results');
    const initial = this._overlay.querySelector('.so-search-initial');
    const empty = this._overlay.querySelector('.so-search-empty');
    const grid = this._overlay.querySelector('.so-search-results-grid');
    const stats = this._overlay.querySelector('.so-search-results-stats strong');

    if (loader) loader.style.display = 'none';
    if (initial) initial.style.display = 'none';

    if (!items || items.length === 0) {
      if (results) results.style.display = 'none';
      if (empty) empty.style.display = 'flex';
      return;
    }

    if (empty) empty.style.display = 'none';
    if (results) results.style.display = 'block';
    if (stats) stats.textContent = items.length;

    // Render results
    if (grid) {
      grid.innerHTML = items.map(item => this._renderResultItem(item)).join('');
    }
  }

  /**
   * Render a single result item
   * @param {Object} item - Result item
   * @returns {string} HTML string
   * @private
   */
  _renderResultItem(item) {
    if (this._viewMode === 'list') {
      return `
        <div class="so-search-item-row" data-item-id="${item.id}" data-item-type="${item.type}">
          <div class="so-search-item-icon" style="background: ${item.color || 'var(--so-accent-primary)'}">
            <span class="material-icons">${item.icon || 'inventory_2'}</span>
          </div>
          <div class="so-search-item-info">
            <div class="so-search-item-name">${item.name}</div>
            <div class="so-search-item-meta">${item.meta || ''}</div>
          </div>
          ${item.price ? `<div class="so-search-item-price">${item.price}</div>` : ''}
          ${item.badge ? `<span class="so-badge so-badge-soft-${item.badgeType || 'primary'} so-badge-sm">${item.badge}</span>` : ''}
        </div>
      `;
    }

    return `
      <div class="so-search-item-card" data-item-id="${item.id}" data-item-type="${item.type}">
        ${item.image ? `<img src="${item.image}" alt="${item.name}" class="so-search-item-image">` : ''}
        <div class="so-search-item-content">
          <div class="so-search-item-name">${item.name}</div>
          ${item.description ? `<div class="so-search-item-description">${item.description}</div>` : ''}
          <div class="so-search-item-footer">
            ${item.price ? `<span class="so-search-item-price">${item.price}</span>` : ''}
            ${item.badge ? `<span class="so-badge so-badge-soft-${item.badgeType || 'primary'} so-badge-sm">${item.badge}</span>` : ''}
          </div>
        </div>
      </div>
    `;
  }

  /**
   * Show initial state
   * @private
   */
  _showInitialState() {
    const loader = this._overlay.querySelector('.so-search-loading');
    const results = this._overlay.querySelector('.so-search-results');
    const initial = this._overlay.querySelector('.so-search-initial');
    const empty = this._overlay.querySelector('.so-search-empty');

    if (loader) loader.style.display = 'none';
    if (results) results.style.display = 'none';
    if (empty) empty.style.display = 'none';
    if (initial) initial.style.display = 'block';
  }

  // ============================================
  // HISTORY
  // ============================================

  /**
   * Load search history from storage
   * @returns {Array} Search history
   * @private
   */
  _loadHistory() {
    return SixOrbit.getStorage(this.options.storageKey) || [];
  }

  /**
   * Save search history to storage
   * @private
   */
  _saveHistory() {
    SixOrbit.setStorage(this.options.storageKey, this._searchHistory);
  }

  /**
   * Add item to search history
   * @param {string} query - Search query
   * @param {string} title - Selected item title
   * @private
   */
  _addToHistory(query, title) {
    // Remove duplicates
    this._searchHistory = this._searchHistory.filter(h => h.query !== query);

    // Add new entry
    this._searchHistory.unshift({ query, title, timestamp: Date.now() });

    // Limit history size
    this._searchHistory = this._searchHistory.slice(0, this.options.maxHistory);

    this._saveHistory();
  }

  /**
   * Clear search history
   */
  clearHistory() {
    this._searchHistory = [];
    this._saveHistory();
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Open the search overlay
   * @returns {this} For chaining
   */
  open() {
    if (this._isOpen) return this;

    this._isOpen = true;
    this._overlay.classList.add('so-active');
    document.body.style.overflow = 'hidden';

    // Focus input
    setTimeout(() => {
      this._input.focus();
    }, 100);

    this.emit(SOSearchOverlay.EVENTS.OPEN);
    return this;
  }

  /**
   * Close the search overlay
   * @returns {this} For chaining
   */
  close() {
    if (!this._isOpen) return this;

    this._isOpen = false;
    this._overlay.classList.remove('so-active');
    document.body.style.overflow = '';

    // Clear input
    this._input.value = '';
    this._showInitialState();

    this.emit(SOSearchOverlay.EVENTS.CLOSE);
    return this;
  }

  /**
   * Toggle the search overlay
   * @returns {this} For chaining
   */
  toggle() {
    return this._isOpen ? this.close() : this.open();
  }

  /**
   * Check if overlay is open
   * @returns {boolean} Open state
   */
  isOpen() {
    return this._isOpen;
  }

  /**
   * Set search query programmatically
   * @param {string} query - Search query
   * @returns {this} For chaining
   */
  setQuery(query) {
    this._input.value = query;
    if (query) {
      this._performSearch(query);
    } else {
      this._showInitialState();
    }
    return this;
  }
}

// Register component
SOSearchOverlay.register();

// Auto-initialize
document.addEventListener('DOMContentLoaded', () => {
  const overlay = document.querySelector('.so-search-overlay');
  if (overlay) {
    new SOSearchOverlay(document.body);
  }
});

// Expose to global scope
window.SOSearchOverlay = SOSearchOverlay;

// Export for ES modules
export default SOSearchOverlay;
export { SOSearchOverlay };
