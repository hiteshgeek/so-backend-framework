// ============================================
// SIXORBIT UI - DROPDOWN COMPONENT
// Handles all dropdown variations
// ============================================

import SixOrbit from '../core/so-config.js';
import SOComponent from '../core/so-component.js';

/**
 * SODropdown - Base dropdown component
 * Supports standard, searchable, options, and outlet dropdowns
 */
class SODropdown extends SOComponent {
  static NAME = 'dropdown';

  static DEFAULTS = {
    closeOnSelect: true,
    closeOnOutsideClick: true,
    openOnFocus: false,
    searchable: false,
    placeholder: 'Select option',
    searchPlaceholder: 'Search...',
    noResultsText: 'No results found',
    // New options
    autoClose: true,         // true, false, 'inside', 'outside'
    direction: 'down',       // down, up, start, end
    alignment: 'start',      // start, end
    // Selection options
    selectionStyle: 'default', // 'default' (bg + check), 'highlight' (bg only), 'check' (check only)
    multiple: false,         // Allow multiple selections
    multipleStyle: 'checkbox', // 'checkbox' (adds checkbox boxes), 'check' (uses checkmark icons)
    maxSelections: null,     // Max selections allowed (null = unlimited)
    minSelections: null,     // Min selections required (null = 0, can deselect all)
    showActions: false,      // Show "Select All" / "Select None" links for multiple selection
    selectAllText: 'All',    // Text for select all link
    selectNoneText: 'None',  // Text for select none link
    allSelectedText: null,   // Text to show when all items are selected (e.g., "All Outlets")
    multipleSelectedText: '{count} selected', // Text template for multiple selections
  };

  static EVENTS = {
    // Before/After show events (Bootstrap pattern)
    SHOW: 'dropdown:show',       // Before opening (cancelable)
    SHOWN: 'dropdown:shown',     // After opened
    HIDE: 'dropdown:hide',       // Before closing (cancelable)
    HIDDEN: 'dropdown:hidden',   // After closed
    // Other events
    CHANGE: 'dropdown:change',
    SEARCH: 'dropdown:search',
    ACTION: 'dropdown:action',
  };

  /**
   * Initialize the dropdown
   * @private
   */
  _init() {
    // Detect dropdown type
    this._type = this._detectType();

    // Cache elements based on type
    this._cacheElements();

    // State
    this._isOpen = false;
    this._disabled = false;
    this._selectedValues = [];  // Array for multiple selection support
    this._selectedTexts = [];   // Array for multiple selection support
    this._originalItems = [];
    this._focusedIndex = -1;

    // Store original CSS classes for direction/alignment (set via HTML)
    this._originalClasses = {
      dropup: this.element.classList.contains('so-dropup'),
      dropstart: this.element.classList.contains('so-dropstart'),
      dropend: this.element.classList.contains('so-dropend'),
      menuEnd: this.element.classList.contains('so-dropdown-menu-end'),
    };

    // Store original items for filtering
    if (this._itemsList) {
      this._originalItems = Array.from(this._itemsList.children);
    }

    // Parse data attributes for options
    this._parseDataAttributes();

    // Get initial selection
    this._getInitialSelection();

    // Bind events
    this._bindEvents();
  }

  /**
   * Parse data attributes for configuration
   * @private
   */
  _parseDataAttributes() {
    const el = this.element;

    // autoClose
    if (el.hasAttribute('data-so-auto-close')) {
      const val = el.getAttribute('data-so-auto-close');
      if (val === 'true') this.options.autoClose = true;
      else if (val === 'false') this.options.autoClose = false;
      else this.options.autoClose = val; // 'inside' or 'outside'
    }

    // direction
    if (el.hasAttribute('data-so-direction')) {
      this.options.direction = el.getAttribute('data-so-direction');
    }

    // alignment
    if (el.hasAttribute('data-so-alignment')) {
      this.options.alignment = el.getAttribute('data-so-alignment');
    }

    // selectionStyle
    if (el.hasAttribute('data-so-selection-style')) {
      this.options.selectionStyle = el.getAttribute('data-so-selection-style');
    }

    // multiple
    if (el.hasAttribute('data-so-multiple')) {
      this.options.multiple = el.getAttribute('data-so-multiple') !== 'false';
    }

    // maxSelections
    if (el.hasAttribute('data-so-max-selections')) {
      this.options.maxSelections = parseInt(el.getAttribute('data-so-max-selections'), 10) || null;
    }

    // minSelections
    if (el.hasAttribute('data-so-min-selections')) {
      this.options.minSelections = parseInt(el.getAttribute('data-so-min-selections'), 10) || null;
    }

    // multipleStyle
    if (el.hasAttribute('data-so-multiple-style')) {
      this.options.multipleStyle = el.getAttribute('data-so-multiple-style');
    }

    // Apply selection style class
    if (this.options.selectionStyle !== 'default') {
      this.addClass(`so-dropdown-selection-${this.options.selectionStyle}`);
    }

    // Apply multiple class and initialize checkboxes (only if multipleStyle is 'checkbox')
    if (this.options.multiple) {
      this.addClass('so-dropdown-multiple');
      if (this.options.multipleStyle === 'checkbox') {
        this._initCheckboxes();
      } else if (this.options.multipleStyle === 'check') {
        // Add multiple-check class to show check icons with background (not checkboxes)
        this.addClass('so-dropdown-multiple-check');
      }
    }

    // showActions
    if (el.hasAttribute('data-so-show-actions')) {
      this.options.showActions = el.getAttribute('data-so-show-actions') !== 'false';
    }

    // selectAllText
    if (el.hasAttribute('data-so-select-all-text')) {
      this.options.selectAllText = el.getAttribute('data-so-select-all-text');
    }

    // selectNoneText
    if (el.hasAttribute('data-so-select-none-text')) {
      this.options.selectNoneText = el.getAttribute('data-so-select-none-text');
    }

    // Create actions bar for multiple selection if enabled
    if (this.options.multiple && this.options.showActions) {
      this._createActionsBar();
    }

    // allSelectedText
    if (el.hasAttribute('data-so-all-selected-text')) {
      this.options.allSelectedText = el.getAttribute('data-so-all-selected-text');
    }

    // multipleSelectedText
    if (el.hasAttribute('data-so-multiple-selected-text')) {
      this.options.multipleSelectedText = el.getAttribute('data-so-multiple-selected-text');
    }
  }

  /**
   * Initialize checkbox elements for multiple selection items
   * @private
   */
  _initCheckboxes() {
    const itemSelector = this._getItemSelector();
    const items = this.$$(itemSelector);

    items.forEach(item => {
      // Skip if checkbox already exists
      if (item.querySelector('.so-checkbox-box')) return;

      // Create checkbox box element matching .so-checkbox-box structure
      const checkboxBox = document.createElement('span');
      checkboxBox.className = 'so-checkbox-box';
      checkboxBox.innerHTML = '<span class="material-icons">check</span>';

      // Insert at the beginning of the item
      item.insertBefore(checkboxBox, item.firstChild);
    });
  }

  /**
   * Create actions bar with Select All / Select None links
   * @private
   */
  _createActionsBar() {
    if (!this._menu) return;

    // Check if actions bar already exists
    if (this._menu.querySelector('.so-dropdown-actions')) return;

    // Create actions bar
    const actionsBar = document.createElement('div');
    actionsBar.className = 'so-dropdown-actions';

    // Select All link
    const selectAllLink = document.createElement('button');
    selectAllLink.type = 'button';
    selectAllLink.className = 'so-dropdown-action so-dropdown-select-all';
    selectAllLink.textContent = this.options.selectAllText;
    selectAllLink.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      this.selectAll();
    });

    // Separator
    const separator = document.createElement('span');
    separator.className = 'so-dropdown-action-separator';
    separator.textContent = '|';

    // Select None link
    const selectNoneLink = document.createElement('button');
    selectNoneLink.type = 'button';
    selectNoneLink.className = 'so-dropdown-action so-dropdown-select-none';
    selectNoneLink.textContent = this.options.selectNoneText;
    selectNoneLink.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      this.selectNone();
    });

    actionsBar.appendChild(selectAllLink);

    // Only add separator and None link if selectNoneText is not empty
    if (this.options.selectNoneText) {
      actionsBar.appendChild(separator);
      actionsBar.appendChild(selectNoneLink);
    }

    // Insert actions bar at the beginning of menu (or after search if present)
    const searchBox = this._menu.querySelector('.so-searchable-search, .so-dropdown-search');
    if (searchBox) {
      searchBox.after(actionsBar);
    } else {
      this._menu.insertBefore(actionsBar, this._menu.firstChild);
    }

    // Store references
    this._actionsBar = actionsBar;
    this._selectAllLink = selectAllLink;
    this._selectNoneLink = selectNoneLink;
  }

  /**
   * Detect dropdown type based on classes
   * @returns {string} Dropdown type
   * @private
   */
  _detectType() {
    if (this.hasClass('so-searchable-dropdown')) return 'searchable';
    if (this.hasClass('so-options-dropdown')) return 'options';
    if (this.hasClass('so-outlet-dropdown')) return 'outlet';
    return 'standard';
  }

  /**
   * Cache DOM elements based on type
   * @private
   */
  _cacheElements() {
    switch (this._type) {
      case 'searchable':
        // Legacy searchable classes
        this._trigger = this.$('.so-searchable-trigger');
        this._menu = this.$('.so-searchable-menu');
        this._searchInput = this.$('.so-searchable-input');
        this._itemsList = this.$('.so-searchable-items');
        this._selectedEl = this.$('.so-searchable-selected');
        break;

      case 'options':
        this._trigger = this.$('.so-options-trigger');
        this._menu = this.$('.so-options-menu');
        break;

      case 'outlet':
        this._trigger = this.$('.so-outlet-dropdown-trigger');
        this._menu = this.$('.so-outlet-dropdown-menu');
        this._searchInput = this.$('.so-outlet-dropdown-search input');
        this._itemsList = this.$('.so-outlet-dropdown-list');
        this._selectedEl = this.$('.outlet-text');
        break;

      default:
        // Standard dropdown - trigger can be .so-dropdown-trigger, .so-btn, or .so-dropdown-toggle (for navbar)
        this._trigger = this.$('.so-dropdown-trigger') || this.$('.so-dropdown-toggle') || this.$('.so-btn');
        this._menu = this.$('.so-dropdown-menu');
        this._selectedEl = this.$('.so-dropdown-selected');
        // For searchable modifier on standard dropdown
        this._searchInput = this.$('.so-dropdown-search-input');
        this._itemsList = this.$('.so-dropdown-items');
    }
  }

  /**
   * Get initial selection from DOM
   * @private
   */
  _getInitialSelection() {
    const selectedItems = this._menu?.querySelectorAll('.so-selected, .so-active') || [];
    selectedItems.forEach(item => {
      const value = item.dataset.value;
      const text = this._getItemText(item);
      if (value !== undefined) {
        this._selectedValues.push(value);
        this._selectedTexts.push(text);
      }
    });
  }

  /**
   * Bind event listeners
   * @private
   */
  _bindEvents() {
    // Trigger click
    if (this._trigger) {
      this.on('click', this._handleTriggerClick, this._trigger);
    }

    // Item selection - bind directly to menu/items container to handle before stopPropagation
    const itemSelector = this._getItemSelector();
    const itemsContainer = this._itemsList || this._menu;
    if (itemSelector && itemsContainer) {
      // Use direct event listener on the items container
      this._itemClickHandler = (e) => {
        const item = e.target.closest(itemSelector);
        if (item && itemsContainer.contains(item)) {
          this._handleItemClick(e, item);
        }
      };
      this._itemsContainer = itemsContainer;
      itemsContainer.addEventListener('click', this._itemClickHandler);
    }

    // Search input
    if (this._searchInput) {
      this.on('input', this._handleSearch, this._searchInput);
      this.on('click', (e) => e.stopPropagation(), this._searchInput);
    }

    // Prevent menu from closing when clicking inside (based on autoClose)
    if (this._menu) {
      this.on('click', (e) => {
        // Only stop propagation if autoClose is not 'outside'
        if (this.options.autoClose !== 'outside') {
          e.stopPropagation();
        }
      }, this._menu);
    }

    // Close on outside click
    if (this.options.closeOnOutsideClick) {
      this.on('click', this._handleOutsideClick, document);
    }

    // Keyboard navigation
    this.on('keydown', this._handleKeydown, this.element);
  }

  /**
   * Get item selector based on type
   * @returns {string} CSS selector
   * @private
   */
  _getItemSelector() {
    switch (this._type) {
      case 'searchable': return '.so-searchable-item';
      case 'options': return '.so-options-item';
      case 'outlet': return '.so-outlet-dropdown-item';
      default: return '.so-dropdown-item';
    }
  }

  /**
   * Handle trigger click
   * @param {Event} e - Click event
   * @private
   */
  _handleTriggerClick(e) {
    e.preventDefault();
    e.stopPropagation();

    if (this._disabled) return;

    // Close other dropdowns
    this._closeOtherDropdowns();

    // Calculate position for options dropdown
    if (this._type === 'options' && !this._isOpen) {
      this._positionMenu();
    }

    this.toggle();
  }

  /**
   * Handle item click
   * @param {Event} e - Click event
   * @param {Element} item - Clicked item
   * @private
   */
  _handleItemClick(e, item) {
    e.stopPropagation();

    // Check if item is disabled
    if (item.classList.contains('so-disabled') || item.hasAttribute('disabled') || item.getAttribute('aria-disabled') === 'true') {
      return;
    }

    // Options dropdown emits action event
    if (this._type === 'options') {
      const action = item.dataset.action;
      this.emit(SODropdown.EVENTS.ACTION, { action, element: item });

      // Check autoClose for options
      if (this._shouldCloseOnItemClick()) {
        this.close();
      }
      return;
    }

    // Other dropdowns handle selection
    const text = this._type === 'outlet'
      ? item.querySelector('.outlet-item-text')?.textContent.trim() || this._getItemText(item)
      : this._getItemText(item);
    // Use data-value if present, otherwise fall back to text content
    const value = item.dataset.value !== undefined ? item.dataset.value : text;

    // Handle multiple selection
    if (this.options.multiple) {
      this.toggleSelect(value, text, item);
    } else {
      this.select(value, text, item);
    }

    // For multiple selection, don't close on item click by default
    if (!this.options.multiple && this._shouldCloseOnItemClick()) {
      this.close();
    }
  }

  /**
   * Check if dropdown should close on item click based on autoClose
   * @returns {boolean}
   * @private
   */
  _shouldCloseOnItemClick() {
    const autoClose = this.options.autoClose;
    return this.options.closeOnSelect && (autoClose === true || autoClose === 'inside');
  }

  /**
   * Handle search input
   * @param {Event} e - Input event
   * @private
   */
  _handleSearch(e) {
    const query = e.target.value.toLowerCase().trim();
    this._filterItems(query);

    this.emit(SODropdown.EVENTS.SEARCH, { query });
  }

  /**
   * Filter items by search query
   * @param {string} query - Search query
   * @private
   */
  _filterItems(query) {
    this._originalItems.forEach(item => {
      const text = this._getItemText(item).toLowerCase();
      const matches = !query || text.includes(query);
      item.style.display = matches ? '' : 'none';
    });
  }

  /**
   * Get clean text from an item, excluding check icons and checkbox elements
   * @param {Element} item - Item element
   * @returns {string} Clean text content
   * @private
   */
  _getItemText(item) {
    // Clone the item to avoid modifying the original
    const clone = item.cloneNode(true);

    // Remove check icons
    clone.querySelectorAll('.so-dropdown-check, .check-icon, .so-checkbox-box').forEach(el => el.remove());

    // Return trimmed text
    return clone.textContent.trim();
  }

  /**
   * Handle outside click based on autoClose option
   * @param {Event} e - Click event
   * @private
   */
  _handleOutsideClick(e) {
    if (!this._isOpen) return;

    // Skip if flag is set (for programmatic open that triggers during click event)
    if (this._ignoreOutsideClick) return;

    // Don't close if clicking inside this dropdown
    if (this.element.contains(e.target)) return;

    // Don't close if clicking on any dropdown trigger or dropdown element (let that component handle it)
    const dropdownTrigger = e.target.closest('.so-dropdown-trigger, .so-searchable-trigger, .so-options-trigger, .so-outlet-dropdown-trigger, .so-btn[data-so-toggle="dropdown"]');
    const dropdownElement = e.target.closest('.so-dropdown, .so-searchable-dropdown, .so-options-dropdown, .so-outlet-dropdown');
    if (dropdownTrigger || dropdownElement) return;

    // Don't close if clicking on navbar dropdown buttons or their dropdowns (let navbar handle it)
    const navbarDropdownBtn = e.target.closest('.so-navbar-user-btn, .so-navbar-apps-btn, .so-navbar-outlet-btn, .so-navbar-status-btn, .so-navbar-theme-btn');
    const navbarDropdown = e.target.closest('.so-navbar-user-dropdown, .so-navbar-apps, .so-navbar-outlet-dropdown, .so-navbar-status-dropdown, .so-navbar-theme-dropdown');
    if (navbarDropdownBtn || navbarDropdown) return;

    const autoClose = this.options.autoClose;

    // autoClose: false - never close on outside click
    if (autoClose === false) return;

    // autoClose: 'inside' - only close when clicking inside
    if (autoClose === 'inside') return;

    // autoClose: true or 'outside' - close on outside click
    this.close();
  }

  /**
   * Handle keyboard navigation
   * @param {KeyboardEvent} e - Keyboard event
   * @private
   */
  _handleKeydown(e) {
    // Escape to close
    if (e.key === 'Escape' && this._isOpen) {
      e.preventDefault();
      this.close();
      this._trigger?.focus();
      return;
    }

    // ArrowDown to open when closed
    if (e.key === 'ArrowDown' && !this._isOpen) {
      e.preventDefault();
      this.open();
      return;
    }

    // Navigate items when open
    if (this._isOpen) {
      const items = this._getNavigableItems();

      if (e.key === 'ArrowDown') {
        e.preventDefault();
        this._focusNextItem(items, 1);
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        this._focusNextItem(items, -1);
      } else if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        if (this._focusedIndex >= 0 && items[this._focusedIndex]) {
          items[this._focusedIndex].click();
        }
      } else if (e.key === 'Home') {
        e.preventDefault();
        this._focusItem(items, 0);
      } else if (e.key === 'End') {
        e.preventDefault();
        this._focusItem(items, items.length - 1);
      }
    }
  }

  /**
   * Get all navigable (non-disabled) items
   * @returns {Element[]} Array of navigable items
   * @private
   */
  _getNavigableItems() {
    const selector = this._getItemSelector();
    return this.$$(selector).filter(item =>
      !item.classList.contains('so-disabled') &&
      !item.hasAttribute('disabled') &&
      item.getAttribute('aria-disabled') !== 'true' &&
      !item.classList.contains('so-dropdown-header') &&
      !item.classList.contains('so-dropdown-divider') &&
      item.style.display !== 'none'
    );
  }

  /**
   * Focus next/previous item in the list
   * @param {Element[]} items - Navigable items
   * @param {number} direction - 1 for next, -1 for previous
   * @private
   */
  _focusNextItem(items, direction) {
    if (items.length === 0) return;

    let newIndex = this._focusedIndex + direction;

    // Wrap around
    if (newIndex < 0) newIndex = items.length - 1;
    if (newIndex >= items.length) newIndex = 0;

    this._focusItem(items, newIndex);
  }

  /**
   * Focus a specific item by index
   * @param {Element[]} items - Navigable items
   * @param {number} index - Item index
   * @private
   */
  _focusItem(items, index) {
    // Remove focus from all items
    const allItems = this.$$(this._getItemSelector());
    allItems.forEach(item => item.classList.remove('so-focused'));

    // Set new focus
    this._focusedIndex = index;
    if (items[index]) {
      items[index].classList.add('so-focused');
      items[index].scrollIntoView({ block: 'nearest' });
    }
  }

  /**
   * Clear focused item state
   * @private
   */
  _clearFocusedItem() {
    const items = this.$$(this._getItemSelector());
    items.forEach(item => item.classList.remove('so-focused'));
    this._focusedIndex = -1;
  }

  /**
   * Close other open dropdowns
   * @private
   */
  _closeOtherDropdowns() {
    // Close other SODropdown instances properly via their close() method
    document.querySelectorAll('.so-dropdown.so-open, .so-searchable-dropdown.so-open, .so-options-dropdown.so-open, .so-outlet-dropdown.so-open').forEach(dropdown => {
      if (dropdown !== this.element) {
        // Try to get the instance and close it properly
        const instance = SODropdown.getInstance(dropdown);
        if (instance && instance._isOpen) {
          instance._isOpen = false;
          instance.removeClass('so-open', 'position-left', 'position-top');
          instance._removeDirectionClasses();
        } else {
          // Fallback: just remove classes if no instance found
          dropdown.classList.remove('so-open', 'position-left', 'position-top');
          dropdown.classList.remove('so-dropup', 'so-dropstart', 'so-dropend', 'so-dropdown-menu-end');
        }
      }
    });

    // Dispatch event to close navbar custom dropdowns (different event to avoid loops)
    document.dispatchEvent(new CustomEvent('closeNavbarDropdowns'));
  }

  /**
   * Apply direction and alignment classes
   * @private
   */
  _applyDirectionClasses() {
    const direction = this.options.direction;
    const alignment = this.options.alignment;

    // Direction classes (only add if not already present via HTML)
    if (direction === 'up' && !this._originalClasses.dropup) this.addClass('so-dropup');
    if (direction === 'start' && !this._originalClasses.dropstart) this.addClass('so-dropstart');
    if (direction === 'end' && !this._originalClasses.dropend) this.addClass('so-dropend');

    // Alignment class (only add if not already present via HTML)
    if (alignment === 'end' && !this._originalClasses.menuEnd) this.addClass('so-dropdown-menu-end');
  }

  /**
   * Remove direction and alignment classes (only those added dynamically, not via HTML)
   * @private
   */
  _removeDirectionClasses() {
    // Only remove classes that weren't originally set via HTML
    if (!this._originalClasses.dropup) this.removeClass('so-dropup');
    if (!this._originalClasses.dropstart) this.removeClass('so-dropstart');
    if (!this._originalClasses.dropend) this.removeClass('so-dropend');
    if (!this._originalClasses.menuEnd) this.removeClass('so-dropdown-menu-end');
  }

  /**
   * Position options dropdown menu
   * @private
   */
  _positionMenu() {
    if (this._type !== 'options') return;

    // Reset position classes
    this.removeClass('position-left', 'position-top');

    const triggerRect = this._trigger.getBoundingClientRect();
    const menuWidth = this._menu.offsetWidth || 180;
    const menuHeight = this._menu.offsetHeight || 150;

    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;

    const spaceRight = viewportWidth - triggerRect.right;
    const spaceBottom = viewportHeight - triggerRect.bottom;
    const spaceTop = triggerRect.top;

    // Horizontal position
    if (spaceRight >= menuWidth) {
      this.addClass('position-left');
    }

    // Vertical position
    if (spaceBottom < menuHeight + 10 && spaceTop > menuHeight + 10) {
      this.addClass('position-top');
    }
  }

  // ============================================
  // PUBLIC API
  // ============================================

  /**
   * Open the dropdown
   * @returns {this} For chaining
   */
  open() {
    if (this._isOpen || this._disabled) return this;

    // Emit cancelable show event
    const showAllowed = this.emit(SODropdown.EVENTS.SHOW, {}, true, true);
    if (!showAllowed) return this;

    this._isOpen = true;
    this.addClass('so-open');
    this._applyDirectionClasses();

    // Reset keyboard navigation
    this._focusedIndex = -1;

    // Set flag to ignore immediate outside clicks (for programmatic open)
    this._ignoreOutsideClick = true;
    setTimeout(() => {
      this._ignoreOutsideClick = false;
    }, 10);

    // Focus search input if present
    if (this._searchInput) {
      setTimeout(() => this._searchInput.focus(), 50);
    }

    // Emit shown event after transition
    setTimeout(() => {
      this.emit(SODropdown.EVENTS.SHOWN);
    }, 150);

    return this;
  }

  /**
   * Close the dropdown
   * @returns {this} For chaining
   */
  close() {
    if (!this._isOpen) return this;

    // Emit cancelable hide event
    const hideAllowed = this.emit(SODropdown.EVENTS.HIDE, {}, true, true);
    if (!hideAllowed) return this;

    this._isOpen = false;
    this.removeClass('so-open');

    // Clear focused item
    this._clearFocusedItem();

    // Clear search
    if (this._searchInput) {
      this._searchInput.value = '';
      this._filterItems('');
    }

    // Remove position classes AFTER transition completes to prevent jump
    setTimeout(() => {
      this.removeClass('position-left', 'position-top');
      this._removeDirectionClasses();
      this.emit(SODropdown.EVENTS.HIDDEN);
    }, 150);

    return this;
  }

  /**
   * Toggle the dropdown
   * @returns {this} For chaining
   */
  toggle() {
    return this._isOpen ? this.close() : this.open();
  }

  /**
   * Select an option (single selection mode)
   * @param {string} value - Option value
   * @param {string} [text] - Display text
   * @param {Element} [clickedItem] - Clicked item element
   * @returns {this} For chaining
   */
  select(value, text, clickedItem = null) {
    const previousValues = [...this._selectedValues];

    // Clear previous and set new
    this._selectedValues = [value];
    this._selectedTexts = [text];

    // Update display
    if (this._selectedEl) {
      this._selectedEl.textContent = text;
    }

    // Update selected state in menu
    const itemSelector = this._getItemSelector();
    this.$$(itemSelector).forEach(item => {
      // If we have the clicked item, use direct comparison
      // Otherwise fall back to value comparison (for programmatic selection)
      const isSelected = clickedItem
        ? item === clickedItem
        : (item.dataset.value !== undefined ? item.dataset.value === value : this._getItemText(item) === value);
      item.classList.toggle('so-selected', isSelected);
      item.classList.toggle('so-active', isSelected);
    });

    // Emit change event
    this.emit(SODropdown.EVENTS.CHANGE, {
      value,
      text,
      values: this._selectedValues,
      texts: this._selectedTexts,
      previousValues,
    });

    return this;
  }

  /**
   * Toggle selection for multiple mode
   * @param {string} value - Option value
   * @param {string} text - Display text
   * @param {Element} item - Item element
   * @returns {this} For chaining
   */
  toggleSelect(value, text, item) {
    const previousValues = [...this._selectedValues];
    const index = this._selectedValues.indexOf(value);

    if (index > -1) {
      // Check minSelections before deselecting
      const minSelections = this.options.minSelections || 0;
      if (this._selectedValues.length <= minSelections) {
        return this; // Don't allow deselecting below minimum
      }
      // Deselect
      this._selectedValues.splice(index, 1);
      this._selectedTexts.splice(index, 1);
      item.classList.remove('so-selected', 'so-active');
    } else {
      // Check max selections
      if (this.options.maxSelections && this._selectedValues.length >= this.options.maxSelections) {
        return this; // Don't allow more selections
      }
      // Select
      this._selectedValues.push(value);
      this._selectedTexts.push(text);
      item.classList.add('so-selected', 'so-active');
    }

    // Update display
    this._updateMultipleDisplay();

    // Emit change event
    this.emit(SODropdown.EVENTS.CHANGE, {
      value,
      text,
      values: this._selectedValues,
      texts: this._selectedTexts,
      previousValues,
      action: index > -1 ? 'deselect' : 'select',
    });

    return this;
  }

  /**
   * Update display text for multiple selection
   * @private
   */
  _updateMultipleDisplay() {
    if (!this._selectedEl) return;

    const count = this._selectedValues.length;
    const totalItems = this._getTotalSelectableItems();

    if (count === 0) {
      this._selectedEl.textContent = this.options.placeholder;
      this._selectedEl.classList.add('so-placeholder');
    } else if (count === totalItems && this.options.allSelectedText) {
      // All items selected and custom text provided
      this._selectedEl.textContent = this.options.allSelectedText;
      this._selectedEl.classList.remove('so-placeholder');
    } else if (count === 1) {
      this._selectedEl.textContent = this._selectedTexts[0];
      this._selectedEl.classList.remove('so-placeholder');
    } else {
      // Use template with {count} placeholder
      this._selectedEl.textContent = this.options.multipleSelectedText.replace('{count}', count);
      this._selectedEl.classList.remove('so-placeholder');
    }
  }

  /**
   * Get total number of selectable (non-disabled) items
   * @returns {number} Total selectable items
   * @private
   */
  _getTotalSelectableItems() {
    const itemSelector = this._getItemSelector();
    return this.$$(itemSelector).filter(item =>
      !item.classList.contains('so-disabled') &&
      !item.hasAttribute('disabled') &&
      item.getAttribute('aria-disabled') !== 'true'
    ).length;
  }

  /**
   * Get selected value (returns first for multiple, or single value)
   * @returns {string|null} Selected value
   */
  getValue() {
    return this._selectedValues[0] || null;
  }

  /**
   * Get all selected values (for multiple selection)
   * @returns {string[]} Array of selected values
   */
  getValues() {
    return [...this._selectedValues];
  }

  /**
   * Get selected text (returns first for multiple, or single text)
   * @returns {string|null} Selected text
   */
  getText() {
    return this._selectedTexts[0] || null;
  }

  /**
   * Get all selected texts (for multiple selection)
   * @returns {string[]} Array of selected texts
   */
  getTexts() {
    return [...this._selectedTexts];
  }

  /**
   * Clear all selections
   * @returns {this} For chaining
   */
  clearSelection() {
    const previousValues = [...this._selectedValues];

    this._selectedValues = [];
    this._selectedTexts = [];

    // Update UI
    const itemSelector = this._getItemSelector();
    this.$$(itemSelector).forEach(item => {
      item.classList.remove('so-selected', 'so-active');
    });

    // Update display
    if (this.options.multiple) {
      this._updateMultipleDisplay();
    } else if (this._selectedEl) {
      this._selectedEl.textContent = this.options.placeholder;
      this._selectedEl.classList.add('so-placeholder');
    }

    // Emit change event
    this.emit(SODropdown.EVENTS.CHANGE, {
      value: null,
      text: null,
      values: [],
      texts: [],
      previousValues,
      action: 'clear',
    });

    return this;
  }

  /**
   * Select all items (for multiple selection mode)
   * @returns {this} For chaining
   */
  selectAll() {
    if (!this.options.multiple) return this;

    const previousValues = [...this._selectedValues];
    const itemSelector = this._getItemSelector();
    const items = this.$$(itemSelector);

    this._selectedValues = [];
    this._selectedTexts = [];

    items.forEach(item => {
      // Skip disabled items
      if (item.classList.contains('so-disabled') ||
          item.hasAttribute('disabled') ||
          item.getAttribute('aria-disabled') === 'true') {
        return;
      }

      // Skip hidden items (filtered out)
      if (item.style.display === 'none') {
        return;
      }

      const text = this._getItemText(item);
      const value = item.dataset.value !== undefined ? item.dataset.value : text;

      // Check max selections
      if (this.options.maxSelections && this._selectedValues.length >= this.options.maxSelections) {
        return;
      }

      this._selectedValues.push(value);
      this._selectedTexts.push(text);
      item.classList.add('so-selected', 'so-active');
    });

    // Update display
    this._updateMultipleDisplay();

    // Emit change event
    this.emit(SODropdown.EVENTS.CHANGE, {
      value: this._selectedValues[0] || null,
      text: this._selectedTexts[0] || null,
      values: this._selectedValues,
      texts: this._selectedTexts,
      previousValues,
      action: 'selectAll',
    });

    return this;
  }

  /**
   * Deselect all items (alias for clearSelection, for multiple selection mode)
   * @returns {this} For chaining
   */
  selectNone() {
    if (!this.options.multiple) return this;

    // Check minSelections - if set, don't allow selecting none
    const minSelections = this.options.minSelections || 0;
    if (minSelections > 0) {
      return this; // Don't allow deselecting all when minSelections is set
    }

    const previousValues = [...this._selectedValues];

    this._selectedValues = [];
    this._selectedTexts = [];

    // Update UI
    const itemSelector = this._getItemSelector();
    this.$$(itemSelector).forEach(item => {
      item.classList.remove('so-selected', 'so-active');
    });

    // Update display
    this._updateMultipleDisplay();

    // Emit change event
    this.emit(SODropdown.EVENTS.CHANGE, {
      value: null,
      text: null,
      values: [],
      texts: [],
      previousValues,
      action: 'selectNone',
    });

    return this;
  }

  /**
   * Check if dropdown is open
   * @returns {boolean} Open state
   */
  isOpen() {
    return this._isOpen;
  }

  /**
   * Update dropdown position (for dynamic content)
   * @returns {this} For chaining
   */
  update() {
    if (this._isOpen) {
      this._positionMenu();
    }
    return this;
  }

  /**
   * Disable the dropdown
   * @returns {this} For chaining
   */
  disable() {
    this._disabled = true;
    this.addClass('so-disabled');
    if (this._trigger) {
      this._trigger.setAttribute('disabled', '');
      this._trigger.setAttribute('aria-disabled', 'true');
    }
    if (this._isOpen) {
      this.close();
    }
    return this;
  }

  /**
   * Enable the dropdown
   * @returns {this} For chaining
   */
  enable() {
    this._disabled = false;
    this.removeClass('so-disabled');
    if (this._trigger) {
      this._trigger.removeAttribute('disabled');
      this._trigger.removeAttribute('aria-disabled');
    }
    return this;
  }

  /**
   * Check if dropdown is disabled
   * @returns {boolean} Disabled state
   */
  isDisabled() {
    return this._disabled;
  }

  /**
   * Enable or disable a specific item
   * @param {string|number} identifier - Value or index of item
   * @param {boolean} disabled - Whether to disable
   * @returns {this} For chaining
   */
  setItemDisabled(identifier, disabled = true) {
    const items = this.$$(this._getItemSelector());
    const item = typeof identifier === 'number'
      ? items[identifier]
      : items.find(i => i.dataset.value === identifier);

    if (item) {
      item.classList.toggle('so-disabled', disabled);
      if (disabled) {
        item.setAttribute('aria-disabled', 'true');
      } else {
        item.removeAttribute('aria-disabled');
      }
    }
    return this;
  }

  // ============================================
  // STATIC FACTORY METHODS
  // ============================================

  /**
   * Create a standard dropdown programmatically
   * @param {Object} options - Dropdown configuration
   * @returns {HTMLElement} Created dropdown element
   */
  static create(options = {}) {
    const { placeholder = 'Select option', items = [], className = '' } = options;

    const dropdown = document.createElement('div');
    dropdown.className = `so-dropdown ${className}`.trim();

    const selectedItem = items.find(i => i.selected);

    dropdown.innerHTML = `
      <button type="button" class="so-dropdown-trigger">
        <span class="so-dropdown-selected">${selectedItem?.label || placeholder}</span>
        <span class="material-icons so-dropdown-arrow">expand_more</span>
      </button>
      <div class="so-dropdown-menu">
        ${items.map(item => `
          <div class="so-dropdown-item ${item.selected ? 'so-selected' : ''} ${item.disabled ? 'so-disabled' : ''}"
               data-value="${item.value}"
               ${item.disabled ? 'aria-disabled="true"' : ''}>
            ${item.icon ? `<span class="material-icons">${item.icon}</span>` : ''}
            ${item.label}
          </div>
        `).join('')}
      </div>
    `;

    return dropdown;
  }

  /**
   * Create a searchable dropdown programmatically
   * @param {Object} options - Dropdown configuration
   * @returns {HTMLElement} Created dropdown element
   */
  static createSearchable(options = {}) {
    const {
      placeholder = 'Select option',
      searchPlaceholder = 'Search...',
      items = [],
      className = ''
    } = options;

    const dropdown = document.createElement('div');
    dropdown.className = `so-searchable-dropdown ${className}`.trim();

    const selectedItem = items.find(i => i.selected);

    dropdown.innerHTML = `
      <button type="button" class="so-searchable-trigger">
        <span class="so-searchable-selected">${selectedItem?.label || placeholder}</span>
        <span class="material-icons so-dropdown-arrow">expand_more</span>
      </button>
      <div class="so-searchable-menu">
        <div class="so-searchable-search">
          <span class="material-icons">search</span>
          <input type="text" class="so-searchable-input" placeholder="${searchPlaceholder}">
        </div>
        <div class="so-searchable-items">
          ${items.map(item => `
            <div class="so-searchable-item ${item.selected ? 'so-selected' : ''} ${item.disabled ? 'so-disabled' : ''}"
                 data-value="${item.value}"
                 ${item.disabled ? 'aria-disabled="true"' : ''}>
              ${item.label}
            </div>
          `).join('')}
        </div>
      </div>
    `;

    return dropdown;
  }

  /**
   * Create an options dropdown programmatically
   * @param {Object} options - Dropdown configuration
   * @returns {HTMLElement} Created dropdown element
   */
  static createOptions(options = {}) {
    const { icon = 'more_vert', items = [], className = '' } = options;

    const dropdown = document.createElement('div');
    dropdown.className = `so-options-dropdown ${className}`.trim();

    dropdown.innerHTML = `
      <button type="button" class="so-options-trigger">
        <span class="material-icons">${icon}</span>
      </button>
      <div class="so-options-menu">
        ${items.map(item => {
          if (item.divider) {
            return '<div class="so-options-divider"></div>';
          }
          if (item.header) {
            return `<div class="so-dropdown-header">${item.header}</div>`;
          }
          return `
            <div class="so-options-item ${item.danger ? 'so-danger' : ''} ${item.disabled ? 'so-disabled' : ''}"
                 data-action="${item.action || ''}"
                 ${item.disabled ? 'aria-disabled="true"' : ''}>
              ${item.icon ? `<span class="material-icons">${item.icon}</span>` : ''}
              <span>${item.label}</span>
            </div>
          `;
        }).join('')}
      </div>
    `;

    return dropdown;
  }
}

// Register component
SODropdown.register();

// Expose to global scope
window.SODropdown = SODropdown;

// Export for ES modules
export default SODropdown;
export { SODropdown };
