// ============================================
// GLOBAL SEARCH CONTROLLER
// Standalone search overlay functionality
// ============================================

// Use prefix from SixOrbit config (fallback to 'so' if not available)
const PREFIX = (typeof window !== 'undefined' && window.SixOrbit?.PREFIX) || 'so';
const cls = (...parts) => `${PREFIX}-${parts.join('-')}`;

/**
 * GlobalSearchController - Standalone search overlay controller
 * This is independent of the SO Framework and can be configured
 * with custom API endpoints and callbacks
 */
class GlobalSearchController {
  // Default configuration
  static DEFAULTS = {
    overlaySelector: '.so-search-overlay',
    inputSelector: '.so-search-overlay-input',
    closeSelector: '.so-search-overlay-close',
    backdropSelector: '.so-search-overlay-backdrop',
    quickLinksSelector: '.so-search-quick-links',
    categoryTabsSelector: '.so-search-category-tabs',
    filterBarSelector: '.so-search-filter-bar',
    resultsContainerSelector: '.so-search-results-container',
    resultsGridSelector: '.so-search-results-grid',
    resultsListSelector: '.so-search-results-list',
    emptySelector: '.so-search-empty',
    loadingSelector: '.so-search-loading',
    debounceMs: 300,
    minSearchLength: 2,
  };

  /**
   * Create a new GlobalSearchController
   * @param {Object} options - Configuration options
   */
  constructor(options = {}) {
    this.options = { ...GlobalSearchController.DEFAULTS, ...options };

    // State
    this.isOpen = false;
    this.isISVSearch = false;
    this.searchQuery = '';
    this.currentView = 'grid';
    this.activeFilters = { stock: 'all', status: 'all' };
    this.activeCategory = 'all';
    this.focusedIndex = -1;
    this.results = [];
    this._debounceTimer = null;

    // Callbacks
    this.onSearch = options.onSearch || null;
    this.onItemClick = options.onItemClick || null;
    this.onAccountClick = options.onAccountClick || null;
    this.onQuickActionClick = options.onQuickActionClick || null;

    // API URLs
    this.searchUrl = options.searchUrl || null;
    this.isvSearchUrl = options.isvSearchUrl || null;

    // Initialize
    this._init();
  }

  /**
   * Initialize the controller
   * @private
   */
  _init() {
    // Cache DOM elements
    this._overlay = document.querySelector(this.options.overlaySelector);
    if (!this._overlay) return;

    this._input = this._overlay.querySelector(this.options.inputSelector);
    this._closeBtn = this._overlay.querySelector(this.options.closeSelector);
    this._backdrop = this._overlay.querySelector(this.options.backdropSelector);
    this._quickLinks = this._overlay.querySelector(this.options.quickLinksSelector);
    this._categoryTabs = this._overlay.querySelector(this.options.categoryTabsSelector);
    this._filterBar = this._overlay.querySelector(this.options.filterBarSelector);
    this._resultsContainer = this._overlay.querySelector(this.options.resultsContainerSelector);
    this._resultsGrid = this._overlay.querySelector(this.options.resultsGridSelector);
    this._resultsList = this._overlay.querySelector(this.options.resultsListSelector);
    this._empty = this._overlay.querySelector(this.options.emptySelector);
    this._loading = this._overlay.querySelector(this.options.loadingSelector);

    // Bind events
    this._bindEvents();

    // Store global reference
    window.globalSearchController = this;
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Global keyboard shortcut (Ctrl/Cmd + K)
    document.addEventListener('keydown', (e) => this._handleGlobalKeydown(e));

    // Close button
    if (this._closeBtn) {
      this._closeBtn.addEventListener('click', () => this.close());
    }

    // Backdrop click
    if (this._backdrop) {
      this._backdrop.addEventListener('click', () => this.close());
    }

    // Search input
    if (this._input) {
      this._input.addEventListener('input', (e) => this._handleInput(e));
      this._input.addEventListener('keydown', (e) => this._handleInputKeydown(e));
    }

    // Category tabs
    this._overlay.querySelectorAll('.so-search-category-tab').forEach(tab => {
      tab.addEventListener('click', (e) => this._handleCategoryClick(e));
    });

    // View toggle buttons
    this._overlay.querySelectorAll('.so-search-view-btn').forEach(btn => {
      btn.addEventListener('click', (e) => this._handleViewToggle(e));
    });

    // Filter dropdowns
    this._initFilters();

    // Quick links
    this._overlay.querySelectorAll('.so-search-quick-link').forEach(link => {
      link.addEventListener('click', (e) => this._handleQuickLinkClick(e));
    });

    // Result clicks (using event delegation)
    if (this._resultsContainer) {
      this._resultsContainer.addEventListener('click', (e) => this._handleResultClick(e));
    }

    // Click trigger from navbar search
    const navbarSearch = document.querySelector('.so-navbar-search-input');
    if (navbarSearch) {
      navbarSearch.addEventListener('focus', () => this.open());
      navbarSearch.addEventListener('click', () => this.open());
    }
  }

  /**
   * Handle global keyboard shortcuts
   * @param {KeyboardEvent} e
   * @private
   */
  _handleGlobalKeydown(e) {
    // Open with Ctrl/Cmd + K
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
      e.preventDefault();
      this.toggle();
    }

    // Close with Escape
    if (e.key === 'Escape' && this.isOpen) {
      this.close();
    }
  }

  /**
   * Handle search input
   * @param {Event} e
   * @private
   */
  _handleInput(e) {
    const query = e.target.value.trim();
    this.searchQuery = query;

    // Clear previous debounce
    clearTimeout(this._debounceTimer);

    // Check for ISV mode
    this.isISVSearch = query.toLowerCase().startsWith('isv:');

    // Update UI based on mode
    this._updateSearchMode();

    // Debounce search
    this._debounceTimer = setTimeout(() => {
      if (query.length >= this.options.minSearchLength) {
        this._performSearch(query);
      } else {
        this._showDefaultState();
      }
    }, this.options.debounceMs);
  }

  /**
   * Handle input keydown for navigation
   * @param {KeyboardEvent} e
   * @private
   */
  _handleInputKeydown(e) {
    switch (e.key) {
      case 'ArrowDown':
        e.preventDefault();
        this._focusNext();
        break;
      case 'ArrowUp':
        e.preventDefault();
        this._focusPrev();
        break;
      case 'Enter':
        e.preventDefault();
        this._selectFocused();
        break;
    }
  }

  /**
   * Initialize filter dropdowns
   * @private
   */
  _initFilters() {
    this._overlay.querySelectorAll('.so-search-filter-dropdown').forEach(dropdown => {
      const btn = dropdown.querySelector('.so-search-filter-btn');
      const menu = dropdown.querySelector('.so-search-filter-menu');
      const filterType = dropdown.dataset.filter;

      if (btn && menu) {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          menu.classList.toggle(cls('open'));
        });

        menu.querySelectorAll('.so-search-filter-option').forEach(option => {
          option.addEventListener('click', () => {
            this._selectFilter(filterType, option.dataset.value);
            menu.classList.remove(cls('open'));
          });
        });
      }
    });

    // Close dropdowns on outside click
    document.addEventListener('click', () => {
      this._overlay.querySelectorAll('.so-search-filter-menu').forEach(menu => {
        menu.classList.remove(cls('open'));
      });
    });
  }

  /**
   * Select a filter option
   * @param {string} type - Filter type (stock, status)
   * @param {string} value - Filter value
   * @private
   */
  _selectFilter(type, value) {
    this.activeFilters[type] = value;

    // Update UI
    const dropdown = this._overlay.querySelector(`.so-search-filter-dropdown[data-filter="${type}"]`);
    if (dropdown) {
      dropdown.querySelectorAll('.so-search-filter-option').forEach(opt => {
        opt.classList.toggle(cls('selected'), opt.dataset.value === value);
      });

      const label = dropdown.querySelector('.filter-label');
      const selected = dropdown.querySelector(`.so-search-filter-option[data-value="${value}"]`);
      if (label && selected) {
        label.textContent = selected.textContent.trim();
      }
    }

    // Re-search with new filters
    if (this.searchQuery.length >= this.options.minSearchLength) {
      this._performSearch(this.searchQuery);
    }
  }

  /**
   * Handle category tab click
   * @param {Event} e
   * @private
   */
  _handleCategoryClick(e) {
    const tab = e.currentTarget;
    const category = tab.dataset.category;

    // Update active state
    this._overlay.querySelectorAll('.so-search-category-tab').forEach(t => {
      t.classList.toggle(cls('active'), t === tab);
    });

    this.activeCategory = category;

    // Re-filter results
    if (this.searchQuery.length >= this.options.minSearchLength) {
      this._performSearch(this.searchQuery);
    }
  }

  /**
   * Handle view toggle
   * @param {Event} e
   * @private
   */
  _handleViewToggle(e) {
    const btn = e.currentTarget;
    const view = btn.dataset.view;

    // Update button states
    this._overlay.querySelectorAll('.so-search-view-btn').forEach(b => {
      b.classList.toggle(cls('active'), b === btn);
    });

    this.currentView = view;

    // Update results display
    if (this._resultsGrid) {
      this._resultsGrid.classList.toggle(cls('visible'), view === 'grid');
    }
    if (this._resultsList) {
      this._resultsList.classList.toggle(cls('visible'), view === 'list');
    }

    // Re-render results in new view
    this._renderResults(this.results);
  }

  /**
   * Handle quick link click
   * @param {Event} e
   * @private
   */
  _handleQuickLinkClick(e) {
    e.preventDefault();
    const link = e.currentTarget;
    const action = link.dataset.action;

    if (this.onQuickActionClick) {
      this.onQuickActionClick(action, link);
    }

    // If the quick link has a URL, navigate
    const url = link.getAttribute('href');
    if (url && url !== '#') {
      window.location.href = url;
    }

    this.close();
  }

  /**
   * Handle result item click
   * @param {Event} e
   * @private
   */
  _handleResultClick(e) {
    const item = e.target.closest('.so-search-item-card, .so-search-item-row, .so-search-account-card, .so-search-overlay-item');
    if (!item) return;

    const itemData = {
      id: item.dataset.itemId,
      type: item.dataset.itemType,
      element: item,
    };

    // Call appropriate callback
    if (item.classList.contains('so-search-account-card') && this.onAccountClick) {
      this.onAccountClick(itemData);
    } else if (this.onItemClick) {
      this.onItemClick(itemData);
    }

    this.close();
  }

  /**
   * Update UI based on search mode (normal vs ISV)
   * @private
   */
  _updateSearchMode() {
    if (this._filterBar) {
      this._filterBar.classList.toggle(cls('visible'), this.isISVSearch);
    }
    if (this._categoryTabs) {
      this._categoryTabs.classList.toggle(cls('visible'), !this.isISVSearch && this.searchQuery.length >= this.options.minSearchLength);
    }
  }

  /**
   * Perform search
   * @param {string} query
   * @private
   */
  async _performSearch(query) {
    this._showLoading();

    try {
      let results;

      if (this.isISVSearch) {
        // ISV search
        const isvQuery = query.replace(/^isv:/i, '').trim();
        results = await this._fetchISVResults(isvQuery);
      } else {
        // Normal search
        results = await this._fetchSearchResults(query);
      }

      this.results = results;
      this._renderResults(results);

      // Trigger callback
      if (this.onSearch) {
        this.onSearch(query, results);
      }
    } catch (error) {
      console.error('Search error:', error);
      this._showEmpty('error', 'Search Error', 'An error occurred while searching. Please try again.');
    }
  }

  /**
   * Fetch normal search results
   * @param {string} query
   * @returns {Promise<Array>}
   * @private
   */
  async _fetchSearchResults(query) {
    if (this.searchUrl) {
      try {
        // Build URL properly - use window.location.href as base for relative paths
        const url = new URL(this.searchUrl, window.location.href);
        url.searchParams.append('query', query);
        url.searchParams.append('category', this.activeCategory);

        const response = await fetch(url.toString());
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        // Transform JSON structure to flat array for rendering
        return this._transformSearchData(data);
      } catch (error) {
        console.error('Search fetch error:', error);
        return []; // Return empty on error, no fallback
      }
    }

    // No URL configured - return empty (AJAX only mode)
    console.warn('Search URL not configured');
    return [];
  }

  /**
   * Transform JSON data structure to flat array for rendering
   * Server is expected to return already-filtered results based on query parameter
   * @param {Object} data - JSON data with menus, customers, vendors, ledgers arrays
   * @returns {Array}
   * @private
   */
  _transformSearchData(data) {
    const results = [];

    // Transform menus (no client-side filtering - server should filter)
    if (data.menus) {
      data.menus.forEach(item => {
        results.push({
          id: item.id,
          type: 'menu',
          name: item.title,
          icon: item.icon,
          iconColor: item.color,
          path: item.path,
          url: item.href,
        });
      });
    }

    // Transform customers
    if (data.customers) {
      data.customers.forEach(item => {
        results.push({
          id: item.id,
          type: 'customer',
          name: item.title,
          icon: item.icon || 'person',
          iconColor: item.color || 'blue',
          category: 'Customer',
          balance: item.walletBalance,
          details: [
            { label: 'Phone', value: item.mobile },
            { label: 'City', value: item.city },
          ],
        });
      });
    }

    // Transform vendors
    if (data.vendors) {
      data.vendors.forEach(item => {
        results.push({
          id: item.id,
          type: 'vendor',
          name: item.title,
          icon: item.icon || 'storefront',
          iconColor: item.color || 'green',
          category: 'Vendor',
          balance: item.walletBalance,
          details: [
            { label: 'Phone', value: item.mobile },
            { label: 'City', value: item.city },
          ],
        });
      });
    }

    // Transform ledgers
    if (data.ledgers) {
      data.ledgers.forEach(item => {
        results.push({
          id: item.id,
          type: 'ledger',
          name: item.title,
          icon: item.icon || 'account_balance_wallet',
          iconColor: item.color || 'orange',
          category: item.group,
          balance: item.walletBalance,
        });
      });
    }

    return results;
  }

  /**
   * Fetch ISV search results
   * @param {string} query
   * @returns {Promise<Array>}
   * @private
   */
  async _fetchISVResults(query) {
    if (this.isvSearchUrl) {
      try {
        // Build URL properly - use window.location.href as base for relative paths
        const url = new URL(this.isvSearchUrl, window.location.href);
        url.searchParams.append('query', query);
        url.searchParams.append('stock', this.activeFilters.stock);
        url.searchParams.append('status', this.activeFilters.status);

        const response = await fetch(url.toString());
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        // Transform and filter ISV data by query
        return this._transformISVData(data);
      } catch (error) {
        console.error('ISV search fetch error:', error);
        return []; // Return empty on error, no fallback
      }
    }

    // No URL configured - return empty (AJAX only mode)
    console.warn('ISV search URL not configured');
    return [];
  }

  /**
   * Transform ISV JSON data and filter by query
   * Filters items by name/SKU matching query (for static JSON files)
   * @param {Object} data - JSON data with items array
   * @param {string} query - Search query for filtering
   * @returns {Array}
   * @private
   */
  _transformISVData(data) {
    // Return all items - server is expected to return filtered results
    return data.items || [];
  }

  /**
   * Render search results
   * @param {Array} results
   * @private
   */
  _renderResults(results) {
    this._hideLoading();

    // Hide quick links when showing results
    if (this._quickLinks) this._quickLinks.style.display = 'none';

    // Hide search prompt
    this._hideEmpty();

    if (!results || results.length === 0) {
      this._showEmpty('search_off', 'No results found', `No matches for "${this.searchQuery}"`);
      return;
    }

    if (this.isISVSearch) {
      // Show filter bar for ISV search
      if (this._filterBar) this._filterBar.classList.add(cls('visible'));
      if (this._categoryTabs) this._categoryTabs.classList.remove(cls('visible'));
      this._renderISVResults(results);
    } else {
      // Show category tabs for normal search
      if (this._categoryTabs) this._categoryTabs.classList.add(cls('visible'));
      if (this._filterBar) this._filterBar.classList.remove(cls('visible'));
      this._renderNormalResults(results);
    }
  }

  /**
   * Render normal search results (menus, accounts)
   * @param {Array} results
   * @private
   */
  _renderNormalResults(results) {
    // Group results by type
    const grouped = {
      menus: results.filter(r => r.type === 'menu'),
      customers: results.filter(r => r.type === 'customer'),
      vendors: results.filter(r => r.type === 'vendor'),
      ledgers: results.filter(r => r.type === 'ledger'),
    };

    // Update category counts
    this._updateCategoryCounts(grouped);

    // Filter by active category
    let filteredResults = results;
    if (this.activeCategory !== 'all') {
      filteredResults = grouped[this.activeCategory] || [];
    }

    // Render to container
    if (this._resultsContainer) {
      let html = '';

      // Menus section (limit to 10 items like plugins project)
      const menus = this.activeCategory === 'all' ? grouped.menus : (this.activeCategory === 'menus' ? filteredResults : []);
      if (menus.length > 0) {
        html += `
          <div class="${cls('search-overlay-section')}">
            <div class="${cls('search-overlay-section-title')}">Menu & Actions</div>
            <div class="${cls('search-overlay-results')}">
              ${menus.slice(0, 10).map(item => this._renderMenuItem(item)).join('')}
            </div>
          </div>
        `;
      }

      // Accounts section - combine all account types (limit to 12 items like plugins project)
      const allAccounts = [
        ...(this.activeCategory === 'all' || this.activeCategory === 'customers' ? grouped.customers : []),
        ...(this.activeCategory === 'all' || this.activeCategory === 'vendors' ? grouped.vendors : []),
        ...(this.activeCategory === 'all' || this.activeCategory === 'ledgers' ? grouped.ledgers : []),
      ];
      if (allAccounts.length > 0) {
        html += `
          <div class="${cls('search-overlay-section')}">
            <div class="${cls('search-overlay-section-title')}">Accounts</div>
            <div class="${cls('search-account-cards')}">
              ${allAccounts.slice(0, 12).map(item => this._renderAccountCard(item)).join('')}
            </div>
          </div>
        `;
      }

      this._resultsContainer.innerHTML = html;
      this._resultsContainer.style.display = 'block';
    }
  }

  /**
   * Render ISV search results (items/products)
   * @param {Array} results
   * @private
   */
  _renderISVResults(results) {
    // Show the results container for ISV results
    if (this._resultsContainer) {
      this._resultsContainer.style.display = 'block';

      // Restore grid/list structure if destroyed by normal search
      if (!this._resultsContainer.querySelector(this.options.resultsGridSelector)) {
        this._resultsContainer.innerHTML = `
          <div class="${cls('search-results-grid')}"></div>
          <div class="${cls('search-results-list')}"></div>
        `;
        // Re-cache the elements
        this._resultsGrid = this._resultsContainer.querySelector(this.options.resultsGridSelector);
        this._resultsList = this._resultsContainer.querySelector(this.options.resultsListSelector);
      }
    }

    if (this.currentView === 'grid') {
      if (this._resultsGrid) {
        this._resultsGrid.innerHTML = results.map(item => this._renderItemCard(item)).join('');
        this._resultsGrid.classList.add(cls('visible'));
      }
      if (this._resultsList) {
        this._resultsList.classList.remove(cls('visible'));
      }
    } else {
      if (this._resultsList) {
        this._resultsList.innerHTML = `
          <div class="so-search-list-header">
            <span>Item</span>
            <span>Stock</span>
            <span>Price</span>
            <span>Cost</span>
            <span>Vendor</span>
          </div>
          ${results.map(item => this._renderItemRow(item)).join('')}
        `;
        this._resultsList.classList.add(cls('visible'));
      }
      if (this._resultsGrid) {
        this._resultsGrid.classList.remove(cls('visible'));
      }
    }
  }

  /**
   * Render a menu item
   * @param {Object} item
   * @returns {string}
   * @private
   */
  _renderMenuItem(item) {
    return `
      <a href="${item.url || '#'}" class="so-search-overlay-item" data-item-id="${item.id}" data-item-type="menu">
        <div class="so-search-overlay-item-icon ${item.iconColor || 'blue'}">
          <span class="material-icons">${item.icon || 'article'}</span>
        </div>
        <div class="so-search-overlay-item-content">
          <div class="so-search-overlay-item-title">${this._highlightMatch(item.name, this.searchQuery)}</div>
          <div class="so-search-overlay-item-path">${item.path || ''}</div>
        </div>
        <span class="material-icons so-search-overlay-item-arrow">arrow_forward</span>
      </a>
    `;
  }

  /**
   * Render an account card
   * @param {Object} item
   * @returns {string}
   * @private
   */
  _renderAccountCard(item) {
    const balanceClass = item.balance > 0 ? 'positive' : (item.balance < 0 ? 'negative' : 'neutral');
    const balanceText = this._formatWalletBalance(item.balance);

    return `
      <div class="so-search-account-card" data-item-id="${item.id}" data-item-type="${item.type}">
        <div class="so-search-account-card-header">
          <div class="so-search-account-card-icon ${item.iconColor || 'blue'}">
            <span class="material-icons">${item.icon || 'account_circle'}</span>
          </div>
          <div class="so-search-account-card-info">
            <div class="so-search-account-card-name">${this._highlightMatch(item.name, this.searchQuery)}</div>
            <div class="so-search-account-card-category">${item.category || item.type}</div>
          </div>
          <div class="so-search-account-card-balance ${balanceClass}">${balanceText}</div>
        </div>
        ${item.details ? `
          <div class="so-search-account-card-details">
            ${item.details.map(d => `
              <div class="so-search-account-card-detail">
                <div class="so-search-account-card-detail-label">${d.label}</div>
                <div class="so-search-account-card-detail-value">${d.value}</div>
              </div>
            `).join('')}
          </div>
        ` : ''}
      </div>
    `;
  }

  /**
   * Render an item card (grid view)
   * @param {Object} item
   * @returns {string}
   * @private
   */
  _renderItemCard(item) {
    const stockClass = this._getStockClass(item.stock);
    const statusClass = item.status === 'active' ? cls('active') : 'liquidation';

    return `
      <div class="so-search-item-card" data-item-id="${item.id}" data-item-type="item">
        <div class="so-search-item-card-header">
          <div class="so-search-item-card-sku">${item.sku || ''}</div>
          <div class="so-search-item-card-status ${statusClass}">${item.status || 'active'}</div>
        </div>
        <div class="so-search-item-card-title">${this._highlightMatch(item.name, this.searchQuery.replace(/^isv:/i, '').trim())}</div>
        <div class="so-search-item-card-details">
          <div class="so-search-item-card-detail">
            <div class="so-search-item-card-detail-label">Stock</div>
            <div class="so-search-item-card-detail-value ${stockClass}">${item.stock}</div>
          </div>
          <div class="so-search-item-card-detail">
            <div class="so-search-item-card-detail-label">Price</div>
            <div class="so-search-item-card-detail-value">${this._formatCurrency(item.price)}</div>
          </div>
          <div class="so-search-item-card-detail">
            <div class="so-search-item-card-detail-label">Cost</div>
            <div class="so-search-item-card-detail-value">${this._formatCurrency(item.cost)}</div>
          </div>
          <div class="so-search-item-card-detail">
            <div class="so-search-item-card-detail-label">Vendor Stock</div>
            <div class="so-search-item-card-detail-value">${item.vendorStock || 0}</div>
          </div>
        </div>
      </div>
    `;
  }

  /**
   * Render an item row (list view)
   * @param {Object} item
   * @returns {string}
   * @private
   */
  _renderItemRow(item) {
    const stockClass = this._getStockClass(item.stock);

    return `
      <div class="so-search-item-row" data-item-id="${item.id}" data-item-type="item">
        <div class="so-search-item-row-info">
          <div class="so-search-item-row-title">${this._highlightMatch(item.name, this.searchQuery.replace(/^isv:/i, '').trim())}</div>
          <div class="so-search-item-row-sku">${item.sku || ''}</div>
        </div>
        <div class="so-search-item-row-value ${stockClass}">${item.stock}</div>
        <div class="so-search-item-row-value">${this._formatCurrency(item.price)}</div>
        <div class="so-search-item-row-value">${this._formatCurrency(item.cost)}</div>
        <div class="so-search-item-row-value">${item.vendorStock || 0}</div>
      </div>
    `;
  }

  /**
   * Update category counts in tabs
   * @param {Object} grouped
   * @private
   */
  _updateCategoryCounts(grouped) {
    const total = Object.values(grouped).reduce((sum, arr) => sum + arr.length, 0);

    this._overlay.querySelectorAll('.so-search-category-tab').forEach(tab => {
      const category = tab.dataset.category;
      const count = tab.querySelector('.so-search-category-count');
      if (count) {
        const value = category === 'all' ? total : (grouped[category]?.length || 0);
        count.textContent = value;
      }
    });
  }

  // ============================================
  // KEYBOARD NAVIGATION
  // ============================================

  /**
   * Focus next result item
   * @private
   */
  _focusNext() {
    const items = this._overlay.querySelectorAll('.so-search-overlay-item, .so-search-account-card, .so-search-item-card, .so-search-item-row');
    if (items.length === 0) return;

    this.focusedIndex = Math.min(this.focusedIndex + 1, items.length - 1);
    this._updateFocus(items);
  }

  /**
   * Focus previous result item
   * @private
   */
  _focusPrev() {
    const items = this._overlay.querySelectorAll('.so-search-overlay-item, .so-search-account-card, .so-search-item-card, .so-search-item-row');
    if (items.length === 0) return;

    this.focusedIndex = Math.max(this.focusedIndex - 1, 0);
    this._updateFocus(items);
  }

  /**
   * Update focus state on items
   * @param {NodeList} items
   * @private
   */
  _updateFocus(items) {
    items.forEach((item, index) => {
      item.classList.toggle(cls('focused'), index === this.focusedIndex);
    });

    // Scroll into view
    if (items[this.focusedIndex]) {
      items[this.focusedIndex].scrollIntoView({ block: 'nearest' });
    }
  }

  /**
   * Select the focused item
   * @private
   */
  _selectFocused() {
    const focused = this._overlay.querySelector(`.${cls('focused')}`);
    if (focused) {
      focused.click();
    }
  }

  // ============================================
  // UI STATE METHODS
  // ============================================

  /**
   * Show loading state
   * @private
   */
  _showLoading() {
    if (this._loading) this._loading.classList.add(cls('visible'));
    if (this._empty) this._empty.classList.remove(cls('visible'));
    if (this._quickLinks) this._quickLinks.style.display = 'none';
    if (this._resultsContainer) this._resultsContainer.style.display = 'none';
    if (this._resultsGrid) this._resultsGrid.classList.remove(cls('visible'));
    if (this._resultsList) this._resultsList.classList.remove(cls('visible'));
  }

  /**
   * Hide loading state
   * @private
   */
  _hideLoading() {
    if (this._loading) this._loading.classList.remove(cls('visible'));
  }

  /**
   * Show empty state
   * @param {string} icon
   * @param {string} title
   * @param {string} text
   * @private
   */
  _showEmpty(icon, title, text) {
    if (this._empty) {
      const iconEl = this._empty.querySelector('.so-search-empty-icon');
      const titleEl = this._empty.querySelector('.so-search-empty-title');
      const textEl = this._empty.querySelector('.so-search-empty-text');

      if (iconEl) iconEl.textContent = icon;
      if (titleEl) titleEl.textContent = title;
      if (textEl) textEl.textContent = text;

      this._empty.classList.add(cls('visible'));
    }
    // Hide quick links when showing empty state (for "no results" scenario)
    if (this._quickLinks) this._quickLinks.style.display = 'none';
    if (this._resultsContainer) this._resultsContainer.style.display = 'none';
    if (this._resultsGrid) this._resultsGrid.classList.remove(cls('visible'));
    if (this._resultsList) this._resultsList.classList.remove(cls('visible'));
  }

  /**
   * Hide empty state
   * @private
   */
  _hideEmpty() {
    if (this._empty) this._empty.classList.remove(cls('visible'));
  }

  /**
   * Show default state (quick links + search prompt when empty)
   * @private
   */
  _showDefaultState() {
    this._hideLoading();
    if (this._quickLinks) this._quickLinks.style.display = 'block';
    if (this._resultsContainer) this._resultsContainer.style.display = 'none';
    if (this._resultsGrid) this._resultsGrid.classList.remove(cls('visible'));
    if (this._resultsList) this._resultsList.classList.remove(cls('visible'));
    if (this._categoryTabs) this._categoryTabs.classList.remove(cls('visible'));
    if (this._filterBar) this._filterBar.classList.remove(cls('visible'));

    // Show search prompt below quick links
    this._showSearchPrompt();
  }

  /**
   * Show search prompt (without hiding other elements)
   * @private
   */
  _showSearchPrompt() {
    if (this._empty) {
      const iconEl = this._empty.querySelector('.so-search-empty-icon');
      const titleEl = this._empty.querySelector('.so-search-empty-title');
      const textEl = this._empty.querySelector('.so-search-empty-text');

      if (iconEl) iconEl.textContent = 'search';
      if (titleEl) titleEl.textContent = 'Start typing to search';
      if (textEl) textEl.textContent = 'Search for menus, customers, vendors, ledgers or type "isv:" for item search';

      this._empty.classList.add(cls('visible'));
    }
  }

  // ============================================
  // UTILITY METHODS
  // ============================================

  /**
   * Highlight search match in text
   * @param {string} text
   * @param {string} query
   * @returns {string}
   * @private
   */
  _highlightMatch(text, query) {
    if (!query || !text) return text;
    const escaped = this._escapeHtml(query).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const regex = new RegExp(`(${escaped})`, 'gi');
    return this._escapeHtml(text).replace(regex, '<mark>$1</mark>');
  }

  /**
   * Escape HTML special characters
   * @param {string} text
   * @returns {string}
   * @private
   */
  _escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  /**
   * Format currency
   * @param {number} value
   * @returns {string}
   * @private
   */
  _formatCurrency(value) {
    if (value === null || value === undefined) return '-';
    return new Intl.NumberFormat('en-IN', {
      style: 'currency',
      currency: 'INR',
      minimumFractionDigits: 2,
    }).format(value);
  }

  /**
   * Format wallet balance with Cr/Dr suffix
   * @param {number} value
   * @returns {string}
   * @private
   */
  _formatWalletBalance(value) {
    if (value === null || value === undefined || value === 0) return '-';
    const formatted = this._formatCurrency(Math.abs(value));
    return value > 0 ? `${formatted} Cr` : `${formatted} Dr`;
  }

  /**
   * Get stock status class
   * @param {number} stock
   * @returns {string}
   * @private
   */
  _getStockClass(stock) {
    if (stock <= 0) return 'out-of-stock';
    if (stock < 10) return 'low-stock';
    return 'in-stock';
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Configure the search controller
   * @param {Object} config
   */
  configure(config) {
    if (config.searchUrl) this.searchUrl = config.searchUrl;
    if (config.isvSearchUrl) this.isvSearchUrl = config.isvSearchUrl;
    if (config.onSearch) this.onSearch = config.onSearch;
    if (config.onItemClick) this.onItemClick = config.onItemClick;
    if (config.onAccountClick) this.onAccountClick = config.onAccountClick;
    if (config.onQuickActionClick) this.onQuickActionClick = config.onQuickActionClick;
  }

  /**
   * Open the search overlay
   */
  open() {
    if (this.isOpen) return;

    this.isOpen = true;
    this._overlay.classList.add(cls('active'));
    document.body.style.overflow = 'hidden';

    // Focus input
    setTimeout(() => {
      if (this._input) this._input.focus();
    }, 100);

    // Show default state
    this._showDefaultState();
  }

  /**
   * Close the search overlay
   */
  close() {
    if (!this.isOpen) return;

    this.isOpen = false;
    this._overlay.classList.remove(cls('active'));
    document.body.style.overflow = '';

    // Reset state
    if (this._input) this._input.value = '';
    this.searchQuery = '';
    this.isISVSearch = false;
    this.focusedIndex = -1;
    this.results = [];
  }

  /**
   * Toggle the search overlay
   */
  toggle() {
    if (this.isOpen) {
      this.close();
    } else {
      this.open();
    }
  }

  /**
   * Programmatically search
   * @param {string} query
   */
  search(query) {
    if (this._input) {
      this._input.value = query;
    }
    this.searchQuery = query;
    this.isISVSearch = query.toLowerCase().startsWith('isv:');
    this._updateSearchMode();
    this._performSearch(query);
  }
}

// Export
export { GlobalSearchController };
export default GlobalSearchController;
